@if (session('info1'))
    <div class="card">
        <div class="card-body alert alert-danger no-margin">
            {{ session('info1') }}
        </div>
    </div>
@endif
@if (session('info'))
    <div class="card">
        <div class="card-body alert alert-info no-margin">
            {{ session('info') }}
        </div>
    </div>
@endif

@if (session('success'))
    <div class="card">
        <div class="card-body alert alert-success no-margin">
            {{ session('success') }}
        </div>
    </div>
@elseif (session('warning'))
    <div class="card">
        <div class="card-body alert alert-warning no-margin">
            {{ session('warning') }}
        </div>
    </div>
@elseif (session('danger'))
    <div class="card">
        <div class="card-body alert alert-danger no-margin">
            {{ session('danger') }}
        </div>
    </div>
@endif
