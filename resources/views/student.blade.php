<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-4 py-10">
        <main class="bg-white shadow-md rounded-lg overflow-hidden p-6 relative">
            
            <div id="success-alert" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition duration-300">
                <span class="block sm:inline font-semibold" id="success-message"></span>
            </div>

            <h1 class="text-2xl font-bold mb-6 text-gray-700">Student Directory</h1>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            @foreach ($stud_list as $stud)
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">{{ $stud }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($students as $student)
                        <tr id="row-{{ $student->student_id }}" class="bg-white hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->student_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap col-first_name">{{ $student->first_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap col-last_name">{{ $student->last_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap col-email">{{ $student->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap col-course">{{ $student->course }}</td>
                            <td class="px-6 py-4 whitespace-nowrap col-year_level">{{ $student->year_level }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" 
                                        class="text-indigo-600 hover:text-indigo-900 mr-4 transition duration-150"
                                        onclick="openEditModal(
                                            '{{ $student->student_id }}', 
                                            '{{ $student->first_name }}', 
                                            '{{ $student->last_name }}', 
                                            '{{ $student->email }}', 
                                            '{{ $student->course }}',
                                            '{{ $student->year_level }}'
                                        )">
                                    Edit
                                </button>
                                
                                <button type="button" 
                                        class="text-red-600 hover:text-red-900 transition duration-150 inline-block" 
                                        onclick="deleteStudent('{{ $student->student_id }}', '{{ $student->first_name }}')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Student</h3>
            <form id="editForm" onsubmit="submitEdit(event)">
                <input type="hidden" id="edit_student_id">
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="edit_first_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="edit_last_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="edit_email" class="mt-1 block w-full border border-gray-300 rounded-md p-2" disabled>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Course</label>
                    <input type="text" id="edit_course" class="mt-1 block w-full border border-gray-300 rounded-md p-2" disabled>
                </div>
                
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // _method means Method Spoofing
        // 1. Open Modal and fill with data
        function openEditModal(id, firstName, lastName, email, course, yearLevel) {
            document.getElementById('edit_student_id').value = id;
            document.getElementById('edit_first_name').value = firstName;
            document.getElementById('edit_last_name').value = lastName;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_course').value = course;
            
            document.getElementById('editModal').classList.remove('hidden');
        }

        // 2. Close Modal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // 4. Handle Delete (AJAX)
        function deleteStudent(id, firstName) {
            // 1. Ask for confirmation before deleting
            if (confirm(`Are you sure you want to delete ${firstName}?`)) {
                
                // 2. Send the DELETE request to Laravel
                fetch(`/students/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if(result.success) {
                        // 3. Remove the table row instantly from the screen
                        const row = document.getElementById(`row-${id}`);
                        if (row) {
                            row.remove();
                        }

                        // 4. Show the success message at the top
                        const alertBox = document.getElementById('success-alert');
                        document.getElementById('success-message').innerText = result.message;
                        alertBox.classList.remove('hidden');

                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // 3. Handle Form Submit (AJAX)
        function submitEdit(event) {
            event.preventDefault(); // Stop the page from reloading

            const id = document.getElementById('edit_student_id').value;
            const data = {
                first_name: document.getElementById('edit_first_name').value,
                last_name: document.getElementById('edit_last_name').value,
                email: document.getElementById('edit_email').value,
                course: document.getElementById('edit_course').value,
                _method: 'PUT' // Tell Laravel this is an update
            };

            // Send data to Laravel using Fetch API
            fetch(`/students/${id}`, {
                method: 'POST', // We use POST but spoof PUT with the _method above
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if(result.success) {
                    // Update the table row dynamically
                    const row = document.getElementById(`row-${id}`);
                    row.querySelector('.col-first_name').innerText = data.first_name;
                    row.querySelector('.col-last_name').innerText = data.last_name;
                    row.querySelector('.col-email').innerText = data.email;
                    row.querySelector('.col-course').innerText = data.course;

                    // Close the modal
                    closeEditModal();

                    // Show success message
                    const alertBox = document.getElementById('success-alert');
                    document.getElementById('success-message').innerText = result.message;
                    alertBox.classList.remove('hidden');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>