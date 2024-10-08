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
    body,
    html {
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
        text-align: center;
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

    .left-column,
    .right-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .session-details,
    .note-box,
    .position-stats {
        flex: 1;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #f9f9f9;
        margin-bottom: 0;
    }

    .note-box {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .note-container {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        margin-bottom: auto;
    }

    .btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: auto;
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

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content.square-modal {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        margin: 5% auto;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        border-radius: 10px;
        border: 4px solid #4CAF50;
        background-color: #fefefe;
        overflow-y: auto;
        box-sizing: border-box;
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: column;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .modal-header h2,
    .modal-header h3 {
        margin: 0;
        padding: 0px 0px;
        text-align: center;
        color: #4CAF50;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
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
        background-color: rgba(0, 0, 0, 0.5);
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

    .performance-icons-container {
        display: flex;
        justify-content: center;
        gap: 50px;
    }

    .performance-icon-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .performance-icon-box img {
        width: 80px;
        height: 80px;
        crossorigin: anonymous;
    }

    .performance-icon-box p {
        margin: 0;
        font-size: 18px;
        color: #4CAF50;
    }

    .time-played {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }

    .position-stats {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;
    }

    .position-stats h3,
    .position-stats table {
        margin: 0;
    }

    .session-details-box {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .session-details-box .details {
        flex: 1;
    }

    .past-performance-history-box {
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #f9f9f9;
        margin-bottom: 3px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }

    .past-performance-history-box i {
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .flex-container {
            flex-direction: column;
            gap: 10px;
        }

        .left-column,
        .right-column {
            width: 100%;
        }

        .modal-content.square-modal {
            max-height: 80vh;
        }

        .modal-header h2 {
            font-size: 18px;
        }
    }

    @media (max-width: 600px) {
        .modal-content.square-modal {
            max-height: 70vh;
        }

        .modal-header h2 {
            font-size: 16px;
        }
    }

    /* Style for the hidden download section */
    #download-section {
    position: flex;
    transform: scale(0.5); transform-origin: top left;
    top: 0;
    left: 0;
    width: 700px;
    height: 700px;
    background: white;
    z-index: 9999;
    display: block;
    visibility: visible;
    opacity: 1;
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
            <h2>{{ $teamName ?? 'N/A' }} {{ $sessionTotalGoals ?? 0 }} - {{ $manualAwayScore ?? 0 }}
                {{ $manualAwayName ?? 'N/A' }}</h2>
            <div class="session-box">
                <div class="flex-container">
                    <div class="left-column">
                        <table style="width: 100%; border: 2px solid #4CAF50; border-collapse: collapse; margin-bottom: 15px;">
                            <tr>
                                <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-calendar-alt"></i> Session Date:</strong></td>
                                <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $sessionDate ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-clock"></i> Time:</strong></td>
                                <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $sessionTime ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-map-marked-alt"></i> Location:</strong></td>
                                <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $sessionLocation ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-users"></i> Players/Side:</strong></td>
                                <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $totalPlayerPerSide ?? 'N/A' }}</td>
                            </tr>
                        </table>

                        <div class="note-box">
                            <div class="note-container">
                                <span><strong><i class="fas fa-sticky-note"></i> Note:</strong> <span id="note-content">{{ $playerNote ?? '(Add your note)' }}</span></span>
                            </div>
                            <div class="btn-container">
                                <button id="edit-note" class="btn-custom btn-small">Edit Note</button>
                            </div>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="position-stats">
                            <h3>Player Performance</h3>
                            <table style="width: 100%; margin-bottom: 15px; border: 2px solid #4CAF50; border-collapse: collapse;">
                                <tr>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;"><strong>Primary Position:</strong></td>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $primaryPosition ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;"><strong>Secondary Position:</strong></td>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $secondaryPosition ?? 'N/A' }}</td>
                                </tr>
                            </table>

                            <div class="time-played"><i class="fas fa-stopwatch-20"></i> Time Played: {{ $totalDuration ?? 'N/A' }}</div>
                            <div class="performance-icons-container">
                                <div class="performance-icon-box">
                                    <p>Goal</p>
                                    <img src="https://cdn-icons-png.flaticon.com/128/7458/7458881.png" alt="Goal Icon" crossorigin="anonymous">
                                    <p>{{ $totalGoals ?? 0 }}</p>
                                </div>
                                <div class="performance-icon-box">
                                    <p>Assist</p>
                                    <img src="https://cdn-icons-png.flaticon.com/256/893/893831.png" alt="Assist Icon" crossorigin="anonymous">
                                    <p>{{ $totalAssists ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                    <button id="save" class="btn-custom">Insight</button>
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
    <div class="scaled-container">
        <div id="summaryModal" class="modal">
            <div class="modal-content square-modal">
                <span class="close">&times;</span>
                <div class="modal-header" style="margin-bottom: 9px;">
                    <h2 style="
        font-size: 2rem; 
        font-weight: bold; 
        border: 2px solid #4CAF50; 
        padding: 0.5rem 1rem;  
        border-radius: 8px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        background-color: #4CAF50; 
        color: white; 
        text-align: center;
        margin: 0 5%;
    ">
                        Performance Summary of {{ $playerName }}
                    </h2>

                    <div style="
        border: 4px solid #4CAF50; 
        padding: 0.5rem 1rem; 
        border-radius: 8px; 
        background-color: #f9f9f9; 
        text-align: center; 
        margin-top: 1rem; 
        width: 100%;
        box-sizing: border-box;
    ">
                        <h3 style="margin: 0;">Match Result</h3>
                        <table style="
            width: 80%; 
            margin: 0 auto; 
            border: 2px solid #4CAF50; 
            border-collapse: collapse; 
            text-align: center; 
            margin-top: 0.5rem; 
            border-radius: 8px;
        ">
                            <tr>
                                <td rowspan="2" style="padding: 0; border: 2px solid #4CAF50;">
                                    <table style="width: 100%; height: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="
                                padding: 0.5rem 1rem; 
                                font-size: 1.125rem; 
                                font-weight: bold; 
                                background-color: #4CAF50; 
                                color: white; 
                                border-bottom: 2px solid white;
                            ">
                                                {{ $teamName ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="
                                padding: 0.5rem 1rem; 
                                font-size: 1.125rem; 
                                font-weight: bold; 
                                background-color: #4CAF50; 
                                color: white;
                            ">
                                                {{ $manualAwayName ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="
                    padding: 0.5rem 1rem; 
                    border: 2px solid #4CAF50; 
                    font-size: 1.125rem; 
                    font-weight: bold;
                ">
                                    {{ $sessionTotalGoals ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td style="
                    padding: 0.5rem 1rem; 
                    border: 2px solid #4CAF50; 
                    font-size: 1.125rem; 
                    font-weight: bold;
                ">
                                    {{ $manualAwayScore ?? 0 }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="modal-body" style="padding: -1px 0px; margin:-2px -1px;">
                    <div class="flex-container">
                        <div class="left-column">
                            <table style="width: 100%; border: 4px solid #4CAF50; border-collapse: collapse; margin-bottom: 15px;">
                                <tr>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-calendar-alt"></i> Session Date:</strong></td>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $sessionDate ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-clock"></i> Time:</strong></td>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $sessionTime ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-map-marked-alt"></i> Location:</strong></td>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $sessionLocation ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;"><strong><i class="fas fa-users"></i> Players/Side:</strong></td>
                                    <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $totalPlayerPerSide ?? 'N/A' }}</td>
                                </tr>
                            </table>

                            <div class="past-performance note-box" style="text-align: center; border: 4px solid #4CAF50; padding: 11px; border-radius: 0px; margin-top: -15px;">
                                <div class="left-column">
                                    <div class="note-container" style="display: flex; justify-content: center; align-items: center; margin-bottom: 0;">
                                        <span style="display: flex; align-items: center; font-size: 18px; margin-bottom: 0;">
                                            <strong style="color: #4CAF50;"><i class="fas fa-history" style="margin-right: 0px; margin-top: 5px"></i> Previous Player History:</strong>
                                        </span>
                                    </div>
                                    <table class="table table-bordered text-center" style="border: 4px solid #4CAF50; border-collapse: collapse; margin: 2px; margin-left: 0px; margin-right: 0px; auto 0;">
                                        <thead style="background-color: #f9f9f9;">
                                            <tr>
                                                <th style="border: 2px solid #4CAF50; height: 30px;"><i class="fas fa-calendar-alt"></i></th>
                                                <th style="border: 2px solid #4CAF50; height: 30px;"><img src="https://cdn-icons-png.flaticon.com/128/7458/7458881.png" alt="Goal Icon" crossorigin="anonymous" width="20" height="20"></th>
                                                <th style="border: 2px solid #4CAF50; height: 30px;"><img src="https://cdn-icons-png.flaticon.com/256/893/893831.png" alt="Assist Icon" crossorigin="anonymous" width="20" height="20"></th>
                                                <th style="border: 2px solid #4CAF50; height: 30px;"><i class="fas fa-stopwatch-20"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="text-align: center; vertical-align: middle;">
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    <strong>{{ $onePriorSessionDate }}</strong></td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $onePriorGoals }}</td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $onePriorAssists }}</td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $onePriorDuration }}</td>
                                            </tr>
                                            <tr style="text-align: center; vertical-align: middle;">
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    <strong>{{ $twoPriorSessionDate }}</strong></td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $twoPriorGoals }}</td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $twoPriorAssists }}</td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $twoPriorDuration }}</td>
                                            </tr>
                                            <tr style="text-align: center; vertical-align: middle;">
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    <strong>{{ $threePriorSessionDate }}</strong></td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $threePriorGoals }}</td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $threePriorAssists }}</td>
                                                <td style="border: 2px solid #4CAF50; height: 30px;">
                                                    {{ $threePriorDuration }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="right-column">
                            <div class="position-stats" style="border: 4px solid #4CAF50; padding: 10px; border-radius: 0px; margin-left: -9px;">
                                <h3 style="color: #4CAF50; font-size: 24px; font-weight: bold;">Player Performance</h3>

                                <table style="width: 100%; margin-bottom: 15px; border: 2px solid #4CAF50; border-collapse: collapse; font-size: 15px; border-radius: 4px;">
                                    <tr>
                                        <td style="border: 2px solid #4CAF50; padding: 8px;"><strong>Primary Position:</strong></td>
                                        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $primaryPosition ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 2px solid #4CAF50; padding: 8px;"><strong>Secondary Position:</strong></td>
                                        <td style="border: 2px solid #4CAF50; padding: 8px;">{{ $secondaryPosition ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="performance-icons-container" style="display: flex; justify-content: space-around; gap: 15px;">
                                    <div class="performance-icon-box" style="text-align: center; border: 2px solid #4CAF50; padding: 10px; border-radius: 4px;">
                                        <p>Goal</p>
                                        <img src="https://cdn-icons-png.flaticon.com/128/7458/7458881.png" alt="Goal Icon" crossorigin="anonymous" width="40">
                                        <p>{{ $totalGoals ?? 0 }}</p>
                                    </div>
                                    <div class="performance-icon-box" style="text-align: center; border: 2px solid #4CAF50; padding: 10px; border-radius: 4px;">
                                        <p>Assist</p>
                                        <img src="https://cdn-icons-png.flaticon.com/256/893/893831.png" alt="Assist Icon" crossorigin="anonymous" width="40">
                                        <p>{{ $totalAssists ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="time-played" style="border: 2px solid #4CAF50; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                                    <i class="fas fa-stopwatch-20"></i> Time Played: {{ $totalDuration ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="download" class="btn-custom">Download</button>
            </div>
        </div>
    </div>

    <!-- Hidden download section -->
    <!-- Hidden download section -->
    <div id="download-section" style="position: absolute; top: 0; left: 0; visibility: visible; z-index: -1; width: 800px; height: 800px; ">
    <div class="modal-content square-modal" style="width: 800px; height: 800px; background-color: #ffffff;">
    <h2 style="font-size: 35px; font-weight: bold; border: 4px solid #4CAF50; padding-left: 5px; padding-right: 5px; border-radius: 16px; display: flex; align-items: center; justify-content: center; background-color: #4CAF50; color: white; text-align: center; margin-top: 20px">
    Performance Summary of {{ $playerName }}
</h2>


<div style="border: 3px solid #4CAF50; padding: 6.75px 11.25px; border-radius: 0px; background-color: #f9f9f9; text-align: center; margin-top: -35px; width: 90%; margin-left: auto; margin-right: auto; ">
    <h3 style="margin: 0; font-size: 18px;">Match Result</h3>
    <table style="width: 80%; margin: 0 auto; border: 1.5px solid #4CAF50; border-collapse: collapse; text-align: center; margin-top: 5.25px; border-radius: 0px; font-size: 18px; ">
        <tr>
            <td rowspan="2" style="padding: 0; border: 1.5px solid #4CAF50;">
                <table style="width: 100%; height: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 7.5px 15px; font-size: 13.5px; font-weight: bold; background-color: #4CAF50; color: white; border-bottom: 1.5px solid white;">
                            {{ $teamName ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 7.5px 15px; font-size: 13.5px; font-weight: bold; background-color: #4CAF50; color: white;">
                            {{ $manualAwayName ?? 'N/A' }}
                        </td>
                    </tr>
                </table>
            </td>
            <td style="padding: 7.5px 15px; border: 1.5px solid #4CAF50; font-size: 13.5px; font-weight: bold;">
                {{ $sessionTotalGoals ?? 0 }}
            </td>
        </tr>
        <tr>
            <td style="padding: 7.5px 15px; border: 1.5px solid #4CAF50; font-size: 13.5px; font-weight: bold;">
                {{ $manualAwayScore ?? 0 }}
            </td>
        </tr>
    </table>
</div>


<div class="flex-container" style="font-size: 13.5px; margin-left:-70px; margin-bottom: 25px;">
    <div class="left-column" style=" margin-right:20px; margin-left:20px;">
        <table style="width: 100%; border: 3px solid #4CAF50; border-collapse: collapse; margin-bottom: 11.25px; font-size: 13.5px;">
            <tr>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;"><strong><i class="fas fa-calendar-alt"></i> Session Date:</strong></td>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;">{{ $sessionDate ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;"><strong><i class="fas fa-clock"></i> Time:</strong></td>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;">{{ $sessionTime ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;"><strong><i class="fas fa-map-marked-alt"></i> Location:</strong></td>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;">{{ $sessionLocation ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;"><strong><i class="fas fa-users"></i> Players/Side:</strong></td>
                <td style="border: 1.5px solid #4CAF50; padding: 6px;">{{ $totalPlayerPerSide ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="past-performance note-box" style="text-align: center; border: 3px solid #4CAF50; padding: 8.25px; border-radius: 0px; margin-top: -11.25px; font-size: 13.5px; margin-left:0px;">
            <div class="left-column">
                <div class="note-container" style="display: flex; justify-content: center; align-items: center; margin-bottom: 0;">
                    <span style="display: flex; align-items: center; font-size: 13.5px; margin-bottom: 0;">
                        <strong style="color: #4CAF50;"><i class="fas fa-history" style="margin-right: 0px; margin-top: 3.75px"></i> Previous Player History:</strong>
                    </span>
                </div>
                <table class="table table-bordered text-center" style="border: 3px solid #4CAF50; border-collapse: collapse; margin: 1.5px; margin-left: 0px; margin-right: 0px; auto 0; font-size: 13.5px;">
                    <thead style="background-color: #f9f9f9;">
                        <tr>
                            <th style="border: 1.5px solid #4CAF50; height: 22.5px;"><i class="fas fa-calendar-alt"></i></th>
                            <th style="border: 1.5px solid #4CAF50; height: 22.5px;"><img src="https://cdn-icons-png.flaticon.com/128/7458/7458881.png" alt="Goal Icon" crossorigin="anonymous" width="15" height="15"></th>
                            <th style="border: 1.5px solid #4CAF50; height: 22.5px;"><img src="https://cdn-icons-png.flaticon.com/256/893/893831.png" alt="Assist Icon" crossorigin="anonymous" width="15" height="15"></th>
                            <th style="border: 1.5px solid #4CAF50; height: 22.5px;"><i class="fas fa-stopwatch-20"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align: center; vertical-align: middle;">
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                <strong>{{ $onePriorSessionDate }}</strong></td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $onePriorGoals }}</td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $onePriorAssists }}</td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $onePriorDuration }}</td>
                        </tr>
                        <tr style="text-align: center; vertical-align: middle;">
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                <strong>{{ $twoPriorSessionDate }}</strong></td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $twoPriorGoals }}</td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $twoPriorAssists }}</td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $twoPriorDuration }}</td>
                        </tr>
                        <tr style="text-align: center; vertical-align: middle;">
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                <strong>{{ $threePriorSessionDate }}</strong></td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $threePriorGoals }}</td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $threePriorAssists }}</td>
                            <td style="border: 1.5px solid #4CAF50; height: 22.5px;">
                                {{ $threePriorDuration }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="right-column">
        <div class="position-stats" style="border: 3px solid #4CAF50; padding: 7.5px; border-radius: 0px; margin-left: -6.75px; font-size: 13.5px; width:117%;">
            <h3 style="color: #4CAF50; font-size: 18px; font-weight: bold;">Player Performance</h3>

            <table style="width: 100%; margin-bottom: 11.25px; border: 1.5px solid #4CAF50; border-collapse: collapse; font-size: 13.5px; border-radius: 6px;">
                <tr>
                    <td style="border: 1.5px solid #4CAF50; padding: 6px;"><strong>Primary Position:</strong></td>
                    <td style="border: 1.5px solid #4CAF50; padding: 6px;">{{ $primaryPosition ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="border: 1.5px solid #4CAF50; padding: 6px;"><strong>Secondary Position:</strong></td>
                    <td style="border: 1.5px solid #4CAF50; padding: 6px;">{{ $secondaryPosition ?? 'N/A' }}</td>
                </tr>
            </table>

            <div class="performance-icons-container" style="display: flex; justify-content: space-around; gap: 11.25px;">
                <div class="performance-icon-box" style="text-align: center; border: 1.5px solid #4CAF50; padding: 7.5px; border-radius: 6px;">
                    <p style="font-size: 13.5px;">Goal</p>
                    <img src="https://cdn-icons-png.flaticon.com/128/7458/7458881.png" alt="Goal Icon" crossorigin="anonymous" width="30">
                    <p style="font-size: 13.5px;">{{ $totalGoals ?? 0 }}</p>
                </div>
                <div class="performance-icon-box" style="text-align: center; border: 1.5px solid #4CAF50; padding: 7.5px; border-radius: 6px;">
                    <p style="font-size: 13.5px;">Assist</p>
                    <img src="https://cdn-icons-png.flaticon.com/256/893/893831.png" alt="Assist Icon" crossorigin="anonymous" width="30">
                    <p style="font-size: 13.5px;">{{ $totalAssists ?? 0 }}</p>
                </div>
            </div>
            <div class="time-played" style="border: 1.5px solid #4CAF50; padding: 7.5px; margin-bottom: 11.25px; border-radius: 6px; font-size: 13.5px;">
                <i class="fas fa-stopwatch-20"></i> Time Played: {{ $totalDuration ?? 'N/A' }}
            </div>
        </div>
    </div>
</div>

    </div>
</div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Capture the hidden download section and download it as an image
        // Capture the hidden download section and download it as an image
downloadBtn.onclick = function() {
    var downloadSection = document.getElementById('download-section');

    // Ensure the hidden section is in the visible viewport
    downloadSection.style.visibility = 'visible';

    html2canvas(downloadSection, {
        useCORS: true,
        allowTaint: true,
        windowWidth: downloadSection.scrollWidth,
        windowHeight: downloadSection.scrollHeight,
    }).then((canvas) => {
        var image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
        var link = document.createElement('a');
        link.download = 'summary-image.png';
        link.href = image;
        link.click();

        // Restore visibility after download
        downloadSection.style.visibility = 'hidden';
    });
};

    });
    </script>
</body>

</html>

@endsection
