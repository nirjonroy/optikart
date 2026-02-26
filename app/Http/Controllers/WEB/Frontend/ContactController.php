<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\ContactMessageInformation;
use App\Mail\ContactConfirmation;
use App\Models\ContactMessage;
use App\Models\ContactPage;
use App\Models\EmailTemplate;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactPage::first();

        return view('frontend.contact.index', compact('contact'));
    }

    public function submit(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'subject' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string'],
        ];

        $validated = $request->validate($rules);

        $setting = Setting::select('enable_save_contact_message', 'contact_email')->first();

        if ($setting && $setting->enable_save_contact_message) {
            $contactMessage = new ContactMessage();
            $contactMessage->name = $validated['name'];
            $contactMessage->email = $validated['email'];
            $contactMessage->phone = $validated['phone'] ?? null;
            $contactMessage->subject = $validated['subject'];
            $contactMessage->message = $validated['message'];
            $contactMessage->save();
        }

        MailHelper::setMailConfig();

        $replacements = [
            '{{name}}' => $validated['name'],
            '{{email}}' => $validated['email'],
            '{{phone}}' => $validated['phone'] ?? __('Not provided'),
            '{{subject}}' => $validated['subject'],
            '{{message}}' => $validated['message'],
        ];

        if ($setting && $setting->contact_email) {
            $template = EmailTemplate::find(2);
            $messageBody = $template?->description ?? "Name: {{name}}\nEmail: {{email}}\nPhone: {{phone}}\nSubject: {{subject}}\nMessage: {{message}}";
            $subjectLine = $template?->subject ?? 'New contact request';

            $adminBody = str_replace(array_keys($replacements), array_values($replacements), $messageBody);

            Mail::to($setting->contact_email)->send(new ContactMessageInformation($adminBody, $subjectLine));
        }

        $mail = Mail::to($validated['email']);
        if (filled(config('mail.from.address'))) {
            $mail->bcc(config('mail.from.address'));
        }
        $mail->send(new ContactConfirmation($validated));

        return back()->with('success', __('Your message has been sent successfully.'));
    }
}
