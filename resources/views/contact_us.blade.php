@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <form action="contact" method="post">
        <input class="input-group" name="name" type="text" id="name">
        <input class="input-group" type="email" name="email" id="email">
        <input class="input-group btn" type="submit" value="submit" name="submit">
    </form>
@endsection