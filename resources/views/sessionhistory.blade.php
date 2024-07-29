@extends('layout.master')
@section('contents')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session History</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #4CAF50;
            font-size: 36px;
            margin: 0;
        }

        .performance-summary {
            padding: 20px;
            background-color: #4CAF50;
            border-radius: 8px;
            color: white;
            margin-bottom: 20px;
        }

        .performance-summary h2 {
            margin-top: 0;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .performance-summary-2 h3 {
            margin-top: 0;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .performance-summary h2 i {
            margin-right: 10px;
        }

        .session-box {
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .session-box h3 {
            margin-top: 0;
            font-size: 20px;
            color: #4CAF50;
        }

        .session-box p {
            margin: 5px 0;
        }

        .flex-container {
            display: flex;
            gap: 20px;
        }

        .left-column, .right-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .session-details, .note-box, .position-stats {
            flex: 1;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 0;
        }

        .note-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0;
        }

        .btn-custom {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #45a049;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .performance-icons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .performance-icons img {
            width: 24px;
            height: 24px;
            margin-right: 5px;
        }

        .note-modal {
            display: none;
            position: fixed;
            z-index: 2;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .note-modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            border-radius: 10px;
        }

        .note-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .note-modal-header .close {
            font-size: 28px;
            font-weight: bold;
        }

        .note-modal-body textarea {
            width: 100%;
            height: 100px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            font-size: 14px;
        }

        .note-modal-footer {
            text-align: right;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Performance Summary</h1>
        </div>

        <div class="performance-summary">
            <div class="performance-summary-2">
                <h3>Match Result</h3>
            </div>
            <h2>{{ $teamName ?? 'N/A' }} {{ $sessionTotalGoals ?? 0 }} - {{ $manualAwayScore ?? 0 }} {{ $manualAwayName ?? 'N/A' }}</h2>
            <div class="session-box">
                <div class="flex-container">
                    <div class="left-column">
                        <div class="session-details">
                            <p><strong><i class="fas fa-calendar-alt"></i> Session Date:</strong> {{ $sessionDate ?? 'N/A' }}</p>
                            <p><strong><i class="fas fa-clock"></i> Time:</strong> {{ $sessionTime ?? 'N/A' }}</p>
                            <p><strong><i class="fas fa-map-marked-alt"></i> Location:</strong> {{ $sessionLocation ?? 'N/A' }}</p>
                            <p><strong><i class="fas fa-users"></i> Player per Side:</strong> {{ $totalPlayerPerSide ?? 'N/A' }}</p>
                        </div>
                        <div class="note-box">
                            <div class="note-container">
                                <span><strong><i class="fas fa-sticky-note"></i> Note:</strong> <span id="note-content">{{ $playerNote ?? '(Add your note)' }}</span></span>
                                <button id="edit-note" class="btn-custom btn-small">Edit Note</button>
                            </div>
                        </div>



                    </div>
                    <div class="right-column">
                        <div class="position-stats">
                            <p><strong>Primary Position:</strong> {{ $primaryPosition ?? 'N/A' }}</p>
                            <p><strong>Secondary Position:</strong> {{ $secondaryPosition ?? 'N/A' }}</p>
                            <p><strong>Player Stat:</strong> {{ $totalGoals ?? 0 }} Goals / {{ $totalAssists ?? 0 }} Assists</p>
                            <p><strong><i class="fas fa-stopwatch-20"></i> Time Played:</strong> {{ $totalDuration ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                    <button id="save" class="btn-custom">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Note Modal -->
    <div id="noteModal" class="note-modal">
        <div class="note-modal-content">
            <div class="note-modal-header">
                <h2>Edit Note</h2>
                <span class="close">&times;</span>
            </div>
            <div class="note-modal-body">
                <textarea id="note-editor" class="note-editor"></textarea>
            </div>
            <div class="note-modal-footer">
                <button id="save-note" class="btn-custom">Save</button>
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
            <button id="download" class="btn-custom">Download</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('summaryModal');
            var noteModal = document.getElementById('noteModal');
            var btn = document.querySelector('#save');
            var noteSpan = document.querySelector('#noteModal .close');
            var mainSpan = document.querySelector('#summaryModal .close');
            var downloadBtn = document.getElementById('download');
            var noteContent = document.getElementById('note-content');
            var noteEditor = document.getElementById('note-editor');
            var saveNoteBtn = document.getElementById('save-note');
            var editNoteBtn = document.getElementById('edit-note');

            // Show the note modal when the "Edit Note" button is clicked
            editNoteBtn.onclick = function() {
                noteEditor.value = noteContent.textContent;
                noteModal.style.display = "block";
            };

            // Close the note modal when the 'X' is clicked
            noteSpan.onclick = function() {
                noteModal.style.display = "none";
            };

            // Save the note and update the content
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
                    noteModal.style.display = "none";
                })
                .catch(error => console.error('Error saving note:', error));
            };

            // Opens the modal
            btn.onclick = function() {
                modal.style.display = "block";
            };

            // Closes the modal when 'X' is clicked
            mainSpan.onclick = function() {
                modal.style.display = "none";
            };

            // Closes the modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                if (event.target == noteModal) {
                    noteModal.style.display = "none";
                }
            };

            // Capture the modal content and download it as an image, excluding certain elements
            downloadBtn.onclick = function() {
                // Hide elements that should not be in the screenshot
                mainSpan.style.display = 'none';
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
                    mainSpan.style.display = '';
                    downloadBtn.style.display = '';
                });
            };
        });
    </script>



</body>
</html>
@endsection
