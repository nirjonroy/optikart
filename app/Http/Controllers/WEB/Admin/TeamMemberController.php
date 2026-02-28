<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use File;
use Illuminate\Http\Request;
use Image;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::latest()->get();
        return view('admin.team_member', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.create_team_member');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg',
            'url' => 'nullable|url',
            'status' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Title is required'),
            'role.required' => trans('admin_validation.Title is required'),
            'photo.required' => trans('admin_validation.Image is required'),
            'status.required' => trans('admin_validation.Status is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $member = new TeamMember();

        if ($request->photo) {
            $extention = $request->photo->getClientOriginalExtension();
            $imageName = 'team-member' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/team-members/' . $imageName;

            Image::make($request->photo)
                ->save(public_path() . '/' . $imagePath);

            $member->photo = $imagePath;
        }

        $member->name = $request->name;
        $member->role = $request->role;
        $member->url = $request->url;
        $member->status = $request->status;
        $member->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.team-member.index')->with($notification);
    }

    public function edit($id)
    {
        $teamMember = TeamMember::find($id);
        return view('admin.edit_team_member', compact('teamMember'));
    }

    public function update(Request $request, $id)
    {
        $teamMember = TeamMember::find($id);

        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'url' => 'nullable|url',
            'status' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Title is required'),
            'role.required' => trans('admin_validation.Title is required'),
            'status.required' => trans('admin_validation.Status is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        if ($request->photo) {
            $existingImage = $teamMember->photo;
            $extention = $request->photo->getClientOriginalExtension();
            $imageName = 'team-member' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $imagePath = 'uploads/team-members/' . $imageName;

            Image::make($request->photo)
                ->save(public_path() . '/' . $imagePath);

            $teamMember->photo = $imagePath;
            $teamMember->save();

            if ($existingImage && File::exists(public_path() . '/' . $existingImage)) {
                unlink(public_path() . '/' . $existingImage);
            }
        }

        $teamMember->name = $request->name;
        $teamMember->role = $request->role;
        $teamMember->url = $request->url;
        $teamMember->status = $request->status;
        $teamMember->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.team-member.index')->with($notification);
    }

    public function destroy($id)
    {
        $teamMember = TeamMember::find($id);
        $existingImage = $teamMember->photo;
        $teamMember->delete();

        if ($existingImage && File::exists(public_path() . '/' . $existingImage)) {
            unlink(public_path() . '/' . $existingImage);
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.team-member.index')->with($notification);
    }

    public function changeStatus($id)
    {
        $teamMember = TeamMember::find($id);
        if ($teamMember->status == 1) {
            $teamMember->status = 0;
            $teamMember->save();
            $message = trans('admin_validation.Inactive Successfully');
        } else {
            $teamMember->status = 1;
            $teamMember->save();
            $message = trans('admin_validation.Active Successfully');
        }

        return response()->json($message);
    }
}
