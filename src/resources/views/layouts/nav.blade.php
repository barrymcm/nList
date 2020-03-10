@extends('app')
<ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('contact_us') }}">Contact</a></li>
        <li><a href="{{ route('events.index') }}">Events</a></li>
        <li><a href="{{ route('event_organisers.index') }}">Event Organisers</a></li>
</ul>