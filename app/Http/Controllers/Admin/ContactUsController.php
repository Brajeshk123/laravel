<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $status = $request->query('status');

        $contacts = ContactUs::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($status === 'unread', fn (Builder $query) => $query->whereNull('read_at'))
            ->when($status === 'read', fn (Builder $query) => $query->whereNotNull('read_at'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $unreadCount = ContactUs::query()->whereNull('read_at')->count();

        return view('admin.contacts.index', compact('contacts', 'search', 'status', 'unreadCount'));
    }

    public function show(ContactUs $contact)
    {
        if ($contact->read_at === null && ! session()->pull('keep_contact_unread')) {
            $contact->update(['read_at' => now()]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function markUnread(ContactUs $contact)
    {
        $contact->update(['read_at' => null]);

        return back()
            ->with('keep_contact_unread', true)
            ->with('success', 'Contact message marked as unread.');
    }

    public function destroy(ContactUs $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
