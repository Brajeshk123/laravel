@extends('admin.layouts.app')

@section('title', 'Contact Message')

@section('page-title', 'Contact Message')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Website
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.contacts.index') }}">Contact Entries</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Message
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">{{ $contact->subject }}</h4>
        <p class="text-muted mb-0">
            Submitted {{ $contact->created_at?->format('M d, Y h:i A') }}
        </p>
    </div>

    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Message</span>

                @if($contact->is_read)
                    <span class="badge bg-secondary">Read</span>
                @else
                    <span class="badge bg-success">Unread</span>
                @endif
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-line;">{{ $contact->message }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                Sender
            </div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt>Name</dt>
                    <dd>{{ $contact->name }}</dd>

                    <dt>Email</dt>
                    <dd>
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ rawurlencode($contact->subject) }}">
                            {{ $contact->email }}
                        </a>
                    </dd>

                    <dt>Phone</dt>
                    <dd>{{ $contact->phone ?: '-' }}</dd>

                    <dt>IP Address</dt>
                    <dd>{{ $contact->ip_address ?: '-' }}</dd>

                    <dt>User Agent</dt>
                    <dd class="small text-muted">{{ $contact->user_agent ?: '-' }}</dd>
                </dl>
            </div>
            <div class="card-footer d-flex gap-2">
                <a
                    href="mailto:{{ $contact->email }}?subject=Re: {{ rawurlencode($contact->subject) }}"
                    class="btn btn-primary btn-sm">
                    Reply
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.contacts.mark-unread', $contact->id) }}">
                    @csrf
                    @method('PATCH')

                    <button class="btn btn-warning btn-sm">
                        Mark Unread
                    </button>
                </form>

                @can('delete contacts')
                    <form
                        method="POST"
                        action="{{ route('admin.contacts.destroy', $contact->id) }}">
                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this contact message?')">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>

@endsection
