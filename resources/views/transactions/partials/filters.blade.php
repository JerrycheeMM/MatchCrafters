@php
    $today = strval(date('Y-m-d'));
    $minDay = strval(date('Y-m-d', strtotime($today. ' + 6 days')));
@endphp
<div class="filters">
    <div  id="transactionFilters" style="padding: 10px;">
        <form action="">
            <label for="" class="mb-1 mt-3">Created At</label>
            <div class="input-group">
                <input id="start-date" type="date" name="filter[after]" class="form-control form-control-sm"
                       data-mask-clearifnotmatch="true"
                       value="{{ request('filter.after', "$today") }}"
                       autocomplete="off" maxlength="10">
                <span class="mx-2">-</span>
                <input id="end-date" type="date" name="filter[before]" class="form-control form-control-sm"
                       data-mask-clearifnotmatch="true"
                       value="{{ request('filter.before', "$today") }}"
                       min="{{ request('filter.after', "$minDay") }}"
                       max="{{ request('filter.before', "$today") }}"
                       autocomplete="off" maxlength="10">
            </div>

            <button class="btn btn-sm btn-secondary w-100 mt-3" type="submit">
                Apply
            </button>
        </form>
    </div>
    @if(count(request('filter', [])) > 0)
        @foreach(request('filter', []) as $filter => $value)
            @if(!empty($value))
                <div class="tag mx-1">
                    <strong class="mr-1">{{ $filter }}:</strong> {{ $value }}
                    <a href="#" class="tag-addon" data-remove-filter="filter[{{ $filter }}]"><i class="fe fe-x"></i></a>
                </div>
            @endif
        @endforeach
    @endif
</div>
