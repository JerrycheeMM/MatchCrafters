<div class="row">
    <div class="col">
        <p>
            <strong> Type </strong>
            <br/>
            {{ $transfer->type_of_customer }}
        </p>
        <p>
            <strong>ID No. </strong>
            <br/>
            {{ $transfer->sender_id_no }}
        </p>

        <p>
            <strong>Date of Birth</strong>
            <br/>
            {{ $transfer->sender_date_of_birth }}
        </p>
    </div>
    <div class="col">
        <p>
            <strong>Nationality</strong>
            <br/>
            {{ $transfer->sender_nationality }}
        </p>
        <p>
            <strong>Address</strong>
            <br/>
            {{ $transfer->sender_address }}
        </p>
        <p>
            <strong>Occupation/Nature of Business</strong>
            <br/>
            {{ $transfer->occupation_or_business_type }}
        </p>
    </div>
</div>
