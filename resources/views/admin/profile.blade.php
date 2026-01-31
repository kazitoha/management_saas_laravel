@extends('admin.layout.app')

@section('admin-content')
    @php
        $user = auth()->user();

        $stats = [
            ['label' => 'Tasks', 'value' => 3],
            ['label' => 'Completed', 'value' => 2],
            ['label' => 'Overdue', 'value' => 1],
            ['label' => 'Reminders', 'value' => 0],
        ];

        $activity = [
            ['label' => 'Logged in', 'time' => 'Today'],
            ['label' => 'Updated profile photo', 'time' => 'Jan 29'],
            ['label' => 'Reset password', 'time' => 'Jan 20'],
        ];
    @endphp

    <x-profile :user="$user" :stats="$stats" :activity="$activity" />
@endsection
