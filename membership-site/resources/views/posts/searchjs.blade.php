@extends('layouts.app')

@section('content')
  <div class="container">
    <ais-index app-id="{{ config('scout.algolia.id') }}"
              api-key="{{ env('ALGOLIA_SEARCH') }}"
              index-name="posts">
      <h1>Search Posts</h1>
      <ais-input plcaeholder="Search for a post"></ais-input>
      <hr />

      <ais-results></ais-results>
    </ais-index>
  </div>
@endsection