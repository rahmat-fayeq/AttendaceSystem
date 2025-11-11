@extends('layout.index')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center">
            <div class="card card-border bg-base-100 w-full md:w-96">
                <div class="card-body space-y-4">
                    <h2 class="card-title text-center text-2xl font-semibold">Add Student</h2>
                    <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="form-control">
                            <label class="label"><span class="label-text">Device User ID (optional)</span></label>
                            <input type="number" name="device_user_id" class="input input-bordered w-full">
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Name</span></label>
                            <input type="text" name="name" class="input input-bordered w-full" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Father Name</span></label>
                            <input type="text" name="father_name" class="input input-bordered w-full" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Department</span></label>
                            <input type="text" name="department" class="input input-bordered w-full" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Phone Number (optional)</span></label>
                            <input type="number" name="phone_number" class="input input-bordered w-full">
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Email (optional)</span></label>
                            <input type="email" name="email" class="input input-bordered w-full">
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">Save Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
