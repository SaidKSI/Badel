<div>
    @extends('dashbored')

    @section('inner_content')

    <div class="row">

        <!-- Profile Edit Form -->
        <div class="card">
            <div class="card-body">
                <div class="fw-bold mb-3 text-center" style="font-size: 17px;">
                    Editing Transaction {{$transaction->transaction_id}} for <a
                        href="{{route('user',['id'=>$transaction->user_id])}}">
                        {{ $transaction->user->first_name . " " . $transaction->user->last_name }}
                    </a>
                </div>


                <form class="d-flex justify-content-center"
                    action="{{route('transaction.update',['id'=>$transaction->id])}}">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <label for="sendBank" class="form-label">Send Bank</label>
                            <select class="form-select" id="sendBank" aria-label="Send Bank" name="send_sb_id">
                                <option selected>Choose...</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ $transaction->send_sb_id == $bank->id ?
                                    'selected'
                                    : '' }}>
                                    {{ $bank->Sb_name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount</label>
                            <input name="amount" type="text" class="form-control" id="amount"
                                value="{{$transaction->amount}}">
                        </div>
                        <div class="col-md-6">
                            <label for="sendBank" class="form-label">Amount After Tax</label>
                            <input name="amount" type="text" class="form-control" id="amount_after_tax"
                                value="{{$transaction->amount_after_tax}}">
                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Bedel Id:</label>
                            <input name="amount" type="text" class="form-control" id="transaction_id"
                                value="{{$transaction->transaction_id}}">
                        </div>

                        <div class="col-md-6">
                            <label for="sendBank" class="form-label">Sender Phone</label>
                            <input name="amount" type="text" class="form-control" id="send_phone"
                                value="{{$transaction->send_phone}}">
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select" id="status" aria-label="Status" name="status">
                                <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : ''
                                    }}>Pending</option>
                                <option value="terminated" {{ $transaction->status === 'terminated' ? 'selected' : ''
                                    }}>Terminated</option>
                                <option value="canceled" {{ $transaction->status === 'canceled' ? 'selected' : ''
                                    }}>Canceled</option>
                                <option value="onhold" {{ $transaction->status === 'onhold' ? 'selected' : '' }}>On Hold
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sendBank" class="form-label">Reciever Bank</label>
                            <select class="form-select" id="sendBank" aria-label="Send Bank" name="receiver_sb_id">
                                <option selected>Choose...</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ $transaction->receiver_sb_id == $bank->id ?
                                    'selected'
                                    : '' }}>
                                    {{ $bank->Sb_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sendBank" class="form-label">Reciever Phone</label>
                            <input name="amount" type="text" class="form-control" id="receiver_phone"
                                value="{{$transaction->receiver_phone}}">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Update Transaction</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- End Profile Edit Form -->

    </div>




    @endsection
</div>