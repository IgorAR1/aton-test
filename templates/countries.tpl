<h1>Список стран</h1>

<form id="filterForm" method="get">
    <label>
        <input type="checkbox" data-filter="country">
        Название страны:
        <input type="text" name="filter[country]">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="id">
        ID:
        <input type="text" name="filter[id]">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" >Сортировать по ID</option>
        <option value="country" >Сортировать по названию страны</option>
    </select>

    <select name="order">
        <option value="asc" >По возрастанию</option>
        <option value="desc" >По убыванию</option>
    </select>

    <button type="submit">Фильтровать</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
    </tr>
    {% foreach country in countries %}
    <tr>
        <td>{{ country.id }}</td>
        <td>{{ country.country }}</td>
    </tr>
    {% endforeach %}
</table>

<script>
    document.getElementById('filterForm').addEventListener('submit', function (e) {
        const form = e.target;

        const checkboxes = form.querySelectorAll('input[type=checkbox][data-filter]');

        checkboxes.forEach(checkbox => {
            const fieldName = checkbox.dataset.filter;
            const input = form.querySelector(`[name="filter[${fieldName}]"]`);

            if (!checkbox.checked) {
                if (input) input.disabled = true;
                checkbox.disabled = true; // <-- чекбокс тоже исключаем из формы
            }
        });
    });
</script>
