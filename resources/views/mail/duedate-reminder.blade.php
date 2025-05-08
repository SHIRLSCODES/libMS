<div>
    @if($status == 'due')
        <h2>Hello {{ $borrow->user->name }},</h2>

        <p>This is a friendly reminder that your borrowed book is due soon.</p>

        <ul>
            <li><strong>Book Title:</strong> {{ $borrow->book->title }}</li>
            <li><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($borrow->due_date)->format('F j, Y') }}</li>
        </ul>

        <p>Please ensure you return the book by the due date to avoid any late fees.</p>

    @else
     <p>Hello {{ $borrow->user->name }},</p>
     <p>Your borrowed book "{{ $borrow->book->title }}" is overdue! It was due on {{ \Carbon\Carbon::parse($borrow->due_date)->format('d M Y') }}, You currently owe a fine of ₦{{ number_format($fine) }}.</p>
    @endif

    <p>Thank you for using Smiles library services!</p>
 </div>
 
 