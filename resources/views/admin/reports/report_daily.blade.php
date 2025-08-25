@extends('admin.master')

@section('title', __('messages.report_list'))

@section('content')
<div class="container-fluid py-4">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0 fw-semibold">{{ $pageTitle }}</h5>
                        </div>
                        <div id="alertsContainer" class="mb-4"></div>

                        <div class="col-12 col-lg-12 mx-auto">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Event:</strong> <span id="eventTitle"></span></p>
                    <p><strong>Date:</strong> <span id="eventDate"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: '' // Removed dayGridMonth,listWeek
        },
        events: [{
                title: 'Sale: $500',
                start: '2025-08-10',
                backgroundColor: '#0ea5e9',
                borderColor: '#0ea5e9'
            },
            {
                title: 'Purchase: $250',
                start: '2025-08-14',
                backgroundColor: '#10b981',
                borderColor: '#10b981'
            },
            {
                title: 'Sale: $700',
                start: '2025-08-20',
                backgroundColor: '#0ea5e9',
                borderColor: '#0ea5e9'
            },
            {
                title: 'Purchase: $400',
                start: '2025-08-22',
                backgroundColor: '#10b981',
                borderColor: '#10b981'
            }
        ],
        eventClick: function(info) {
            // Update modal content
            document.getElementById('eventTitle').textContent = info.event.title;
            document.getElementById('eventDate').textContent = info.event.start
        .toLocaleDateString();
            // Show the modal
            eventModal.show();
        }
    });

    calendar.render();
});
</script>
@endsection