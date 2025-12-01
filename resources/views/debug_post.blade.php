@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Debug POST Request</h1>
    
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Test Form</h2>
        <form id="testForm" method="POST" action="/debug-post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Test Field</label>
                <input type="text" name="test_field" class="w-full border rounded px-3 py-2" value="test data">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Test File</label>
                <input type="file" name="test_file" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit POST</button>
        </form>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">JavaScript Test</h2>
        <button id="testFetch" class="bg-green-600 text-white px-4 py-2 rounded mb-4">Test Fetch POST</button>
        <div id="result" class="bg-gray-100 p-4 rounded" style="display:none;"></div>
    </div>
    
    <div class="mt-6">
        <a href="/sales" class="text-blue-600 underline">Back to Sales</a>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('testFetch').addEventListener('click', function() {
    const formData = new FormData();
    formData.append('test_field', 'JavaScript test data');
    formData.append('test_number', '123');
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/debug-post', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('result');
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `
            <h3 class="font-bold mb-2">Fetch Result:</h3>
            <pre>${JSON.stringify(data, null, 2)}</pre>
        `;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
});
</script>
@endpush
@endsection
