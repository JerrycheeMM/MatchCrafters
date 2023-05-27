<div class="row">
    <div class="col">
        <p>
            <strong>Purpose</strong>
            <br/>
            {{ $transfer->purpose }}
        </p>
        <p>
            <strong>Source of Fund</strong>
            <br/>
            {{ $transfer->source_of_fund }}
        </p>
    </div>
    <div class="col">
        <p>
            <strong>Type of Customer</strong>
            <br/>
            {{ $transfer->type_of_customer }}
        </p>
        <p>
            <strong>Partner Transaction Id</strong>
            <br/>
            {{ $transfer->partner_transaction_id }}
        </p>
    </div>
</div>
