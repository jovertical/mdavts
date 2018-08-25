@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            Edit an election
        @endslot

        <li class="breadcrumb-item">
            <a href="{{ route('root.candidates.index') }}">Candidates</a>
        </li>

        <li class="breadcrumb-item active">
            Edit
        </li>
    @endcomponent

  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">---</h4>
                <h6 class="card-subtitle"></h6>

                <form method="POST" action="{{ route('root.candidates.store') }}" class="form-material m-t-40">
                    @csrf

                    <div class="form-group">
                        <!-- First Name -->
                        <div class="col-md">
                            <label for="First_Name">First Name</label>

                            <input type="text" 
                            name="first_name" 
                            id="first_name" 
                            class="form-control form-control-line" 
                            value="{{ old('first_name') ?? $candidates->first_name}}" 
                            placeholder="Enter First Name">
                             
                            @if ($errors->has('first_name'))
                                <span class="text-danger">
                                    {{ $errors->first('first_name') }}
                                </span> @endif
                        </div>
                        <!--/.First Name -->

                        <br/>

                        <!-- Middle Name -->
                        <div class="col-md">
                            <label for="Middle_Name">Middle Name</label>

                            <input type="text" 
                            name="middle_name" 
                            id="middle_name" 
                            class="form-control form-control-line" 
                            value="{{ old('middle_name') ?? $candidates->middle_name }}"
                            placeholder="Enter Middle Name"> 
                            
                            @if ($errors->has('middle_name'))
                                <span class="text-danger">
                                   {{ $errors->first('middle_name') }}
                                </span> @endif
                        </div>
                        <!--/.Middle Name -->

                        <br/>

                        <!-- Last Name -->
                        <div class="col-md">
                            <label for="Last_Name">Last Name</label>

                            <input type="text" 
                            name="last_name" 
                            id="last_name" 
                            class="form-control form-control-line" 
                            value="{{ old('last_name') ?? $candidates->last_name }}"
                            placeholder="Enter Last Name"> 
                            
                            @if ($errors->has('last_name'))
                                <span class="text-danger">
                                    {{ $errors->first('last_name') }}
                                 </span> @endif
                        </div>
                        <!--/.Last Name -->

                        <br/>

                        <!-- Position -->
                        <div class="col-md">
                            <label for="position">Position</label>

                            <input type="text" 
                            name="position" 
                            id="position" 
                            class="form-control form-control-line" 
                            value="{{ old('position') ?? $candidates->position }}" 
                            placeholder="Enter position">                            
                            
                            @if ($errors->has('position'))
                                <span class="text-danger">
                                    {{ $errors->first('position') }}
                                </span> @endif
                        </div>
                        <!--/. Position -->

                        <br/>

                        <!-- Party List -->
                        <div class="col-md">
                            <label for="party_list">Party List</label>

                            <input type="text" 
                            name="party_list" 
                            id="party_list" 
                            class="form-control form-control-line" 
                            value="{{ old('party_list') ?? $candidates->party_list}}"
                            placeholder="Party List"> 
                            
                            @if ($errors->has('party_list'))
                                <span class="text-danger">
                                    {{ $errors->first('party_list') }}
                                </span>
                            @endif
                        </div>
                        <!--/. Party List -->
                    </div>

                    <!-- Grade Level -->
                    <div class="col-md">
                        <label for="grade_level">Grade Level</label>

                        <input type="text" 
                        name="grade_level" 
                        id="grade_level" 
                        class="form-control form-control-line" 
                        value="{{ old('grade_level') ?? $candidates->grade_level }}"
                            placeholder="Grade Level"> @if ($errors->has('grade_level'))
                        <span class="text-danger">
                                    {{ $errors->first('grade_level') }}
                                </span> @endif
                    </div>
                    <!--/. Grade Level -->

                    <br/>
                    <br/>

                    <!-- Submit -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">z
                                <i class="fa fa-plus"></i> Update
                            </button>

                        <a href="{{ route('root.candidates.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                    </div>
                    <!--/. Submit -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="/root/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="/root/assets/plugins/moment/moment.js"></script>
    <script src="/root/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <script>
       $('#start_date').bootstrapMaterialDatePicker({time: false}); 
       $('#end_date').bootstrapMaterialDatePicker({time: false});
    </script>
@endsection
