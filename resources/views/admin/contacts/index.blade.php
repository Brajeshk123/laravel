@extends('admin.layouts.app')

@section('title', 'Contact Entries')

@section('page-title', 'Contact Entries')

@section('breadcrumb')
    <li class="breadcrumb-item">
        Website
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        Contact Entries
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Contact Entries</h4>
        <p class="text-muted mb-0">
            Review messages submitted from the website contact page.
        </p>
    </div>

    <span class="badge bg-primary">
        {{ $unreadCount }} unread
    </span>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-7">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        class="form-control"
                        placeholder="Search name, email, phone, subject, or message...">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All messages</option>
                        <option value="unread" @selected($status === 'unread')>Unread only</option>
                        <option value="read" @selected($status === 'read')>Read only</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-fill">
                        Search
                    </button>

                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="110">Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th width="150">Submitted</th>
                        <th width="170">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr class="{{ $contact->is_read ? '' : 'table-light' }}">
                            <td>
                                @if($contact->is_read)
                                    <span class="badge bg-secondary">Read</span>
                                @else
                                    <span class="badge bg-success">Unread</span>
                                @endif
                            </td>
                            <td>{{ $contact->name }}</td>
                            <td>
                                <a href="mailto:{{ $contact->email }}">
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>{{ $contact->phone ?: '-' }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->created_at?->format('M d, Y h:i A') }}</td>
                            <td>
                                <a
                                    href="{{ route('admin.contacts.show', $contact->id) }}"
                                    class="btn btn-primary btn-sm">
                                    View
                                </a>

                                @can('delete contacts')
                                    <form
                                        method="POST"
                                        action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this contact message?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No contact entries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $contacts->links() }}
    </div>
</div>

@endsection
