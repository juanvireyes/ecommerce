<form action="{{ route('rep.products.export') }}" method="get">
    <label for="day">
        Selecciona el día
    </label>

    <select name="day" id="dateSelector">
        <option value="">Selecciona el día</option>
        @for($day = 1; $day <= 31; $day++)
            <option value="{{ $day }}">{{ $day }}</option>
        @endfor
    </select>

    <label for="month">
        Selecciona el mes
    </label>

    <select name="month" id="month">
        <option value="">Selecciona el mes</option>
        @for($month = 1; $month <= 12; $month++)
            <option value="{{ $month }}">{{ $month }}</option>
        @endfor
    </select>

    <label for="year">
        Selecciona el año
    </label>

    <select name="year" id="year">
        <option value="">Selecciona el año</option>
        @for($year = 2023; $year <= 2080; $year++)
            <option value="{{ $year }}">{{ $year }}</option>
        @endfor
    </select>

    <button type="submit">
        Seleccionar fecha
    </button>
</form>
