@extends('layout.master')
@section('contents')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session History</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <style>
        .note-editor {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome back {{ session('Player_Name') }}!!!</h1>
        </div>

        <div class="performance-summary">
            <h2>Performance Summary:</h2>
            <div class="session-box">
                <h3>{{ $teamName ?? 'N/A' }}</h3>
                <p><strong>Date:</strong> {{ $sessionDate ?? 'N/A' }}</p>
                <p><strong>Time:</strong> {{ $sessionTime ?? 'N/A' }}</p>
                <p><strong>Mode:</strong> {{ $sideId ?? 'N/A' }} Side, {{ $totalPlayerPerSide ?? 'N/A' }} vs {{ $totalPlayerPerSide ?? 'N/A' }}</p>
                <p><strong>Result:</strong> {{ $teamName ?? 'N/A' }} {{ $sessionTotalGoals ?? 0 }} - {{ $manualAwayScore ?? 0 }} {{ $manualAwayName ?? 'N/A' }}</p>
                <p><strong>Location:</strong> {{ $sessionLocation ?? 'N/A' }}</p>
                <p><strong>Primary Position:</strong> {{ $primaryPosition ?? 'N/A' }}</p>
                <p><strong>Secondary Position:</strong> {{ $secondaryPosition ?? 'N/A' }}</p>
                <p><strong>Performance:</strong> {{ $totalGoals ?? 0 }} Goals / {{ $totalAssists ?? 0 }} Assists</p>
                <p><strong>Time Played:</strong> {{ $totalDuration ?? 'N/A' }}</p>
                <p><strong>Note:</strong> <span id="note-content">{{ $playerNote }}</span></p>
                <textarea id="note-editor" class="note-editor"></textarea>
                <button id="save-note" class="note-editor">Save Note</button>
                <button id="create-note" class="note-editor">Create Note</button>
                <button id="save">Save</button>
            </div>
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="summaryModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <img src="{{ session('Player_Image') }}" alt="{{ session('Player_Name') }}" class="modal-profile-pic">
                <h2>{{ $teamName ?? 'N/A' }}</h2>
                <h2>{{ session('Player_Name') }}</h2>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> {{ $sessionDate ?? 'N/A' }}</p>
                <p><strong>Mode:</strong> {{ $sideId ?? 'N/A' }} Side, {{ $totalPlayerPerSide ?? 'N/A' }} vs {{ $totalPlayerPerSide ?? 'N/A' }}</p>
                <p><strong>Result:</strong> {{ $teamName ?? 'N/A' }} {{ $sessionTotalGoals ?? 0 }} - {{ $manualAwayScore ?? 0 }} {{ $manualAwayName ?? 'N/A' }}</p>
                <p><strong>Primary Position:</strong> {{ $primaryPosition ?? 'N/A' }}</p>
                <p><strong>Secondary Position:</strong> {{ $secondaryPosition ?? 'N/A' }}</p>
                <p><strong>Time Played:</strong> {{ $totalDuration ?? 'N/A' }}</p>
                <div class="performance-icons">
                    <img src="https://cdn-icons-png.flaticon.com/512/9009/9009204.png" alt="Goal Icon"> {{ $totalGoals ?? 0 }} Goals
                    <img src="https://cdn-icons-png.flaticon.com/256/893/893831.png" alt="Assist Icon"> {{ $totalAssists ?? 0 }} Assists
                </div>
            </div>
            <button id="download">Download</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('summaryModal');
            var btn = document.querySelector('#save');
            var span = document.getElementsByClassName("close")[0];
            var downloadBtn = document.getElementById('download');
            var noteContent = document.getElementById('note-content');
            var noteEditor = document.getElementById('note-editor');
            var saveNoteBtn = document.getElementById('save-note');
            var createNoteBtn = document.getElementById('create-note');

            // Show or hide Create Note button based on whether the note already exists
            if (noteContent.textContent.trim() !== '(--- Click here to add notes ---)') {
                createNoteBtn.style.display = 'none';
            }

            noteContent.onclick = function() {
                noteEditor.value = noteContent.textContent;
                noteContent.style.display = 'none';
                noteEditor.style.display = 'block';
                saveNoteBtn.style.display = 'block';
                createNoteBtn.style.display = createNoteBtn.style.display === 'none' ? 'none' : 'block';
            };

            saveNoteBtn.onclick = function() {
                var note = noteEditor.value;
                var sessionId = "{{ $sessionId }}";
                var playerId = "{{ $playerId }}";

                fetch('/save-note', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if necessary
                    },
                    body: JSON.stringify({
                        session_id: sessionId,
                        player_id: playerId,
                        player_note: note
                    })
                })
                .then(response => response.json())
                .then(data => {
                    noteContent.textContent = note;
                    noteContent.style.display = 'block';
                    noteEditor.style.display = 'none';
                    saveNoteBtn.style.display = 'none';
                    createNoteBtn.style.display = 'none';
                })
                .catch(error => console.error('Error saving note:', error));
            };

            createNoteBtn.onclick = function() {
                var note = noteEditor.value;
                var sessionId = "{{ $sessionId }}";
                var playerId = "{{ $playerId }}";

                fetch('/create-note', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if necessary
                    },
                    body: JSON.stringify({
                        session_id: sessionId,
                        player_id: playerId,
                        player_note: note
                    })
                })
                .then(response => response.json())
                .then(data => {
                    noteContent.textContent = note;
                    noteContent.style.display = 'block';
                    noteEditor.style.display = 'none';
                    saveNoteBtn.style.display = 'none';
                    createNoteBtn.style.display = 'none';
                })
                .catch(error => console.error('Error creating note:', error));
            };

            // Opens the modal
            btn.onclick = function() {
                modal.style.display = "block";
            };

            // Closes the modal when 'X' is clicked
            span.onclick = function() {
                modal.style.display = "none";
            };

            // Closes the modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Capture the modal content and download it as an image, excluding certain elements
            downloadBtn.onclick = function() {
                // Hide elements that should not be in the screenshot
                span.style.display = 'none';
                downloadBtn.style.display = 'none';

                html2canvas(document.querySelector(".modal-content"), {
                    onclone: function (clonedDoc) {
                        // You can perform additional adjustments if needed here
                    }
                }).then(canvas => {
                    // Convert canvas to image
                    var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                    var link = document.createElement('a');
                    link.download = 'modal-image.png';
                    link.href = image;
                    link.click();

                    // Restore the display of elements after taking the screenshot
                    span.style.display = '';
                    downloadBtn.style.display = '';
                });
            };
        });
    </script>
</body>
</html>
@endsection
