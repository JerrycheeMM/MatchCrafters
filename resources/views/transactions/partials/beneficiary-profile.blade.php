<div class="row">
    <div class="col">
        <p>
            <strong>Type </strong>
            <br/>
            {{ $transfer->type_of_beneficiary }}
        </p>
        <p>
            <strong>ID No. </strong>
            <br/>
            {{ $transfer->beneficiary_id_no }}
        </p>
        <p>
            <strong>Relationship</strong>
            <br/>
            {{ $transfer->readable_relationship }}
        </p>
    </div>
    <div class="col">
        <p>
            <strong>Bank Name</strong>
            <br/>
            {{ $transfer->bank_name }}
        </p>
        <p>
            <strong>Account No.</strong>
            <br/>
            {{ $transfer->account_no }}
        </p>
    </div>
</div>
