<form action="">
    <div class="row pb-4">
        <div class="col-md-3">
            <div class="col-sm-10">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                    value="{{ old('start_date') ? old('start_date') : $startDate }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="col-sm-10">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date"
                    value="{{ old('end_date') ? old('end_date') : $endDate }}">
            </div>
        </div>
        @if (url()->current() == 'http://127.0.0.1:8000/admin/history')
        <div class="col-md-3">
            <div class="col-sm-10">
                <label for="status">Status</label>
                <select class="form-select" id="status" name="status">
                    <option selected>Status</option>
                    <option value="terminated">Terminated</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
        </div>
        @endif
        <div class="col-md-1">
            <button class="btn btn-primary">Search</button>
        </div>
        <div class="col-md-1">
            <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>