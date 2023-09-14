@props(['task'])
<div>
    <div id="author-{{ $task->id }}" class="px-3">
        <small>
            Uploaded by {{ $task->author }} via
            @if ($task->sheets_created_at != '')
                Google Sheets at {{ $task->sheets_created_at }}
            @else
                this website at {{ $task->created_at }}
            @endif
        </small>
    </div>
</div>
