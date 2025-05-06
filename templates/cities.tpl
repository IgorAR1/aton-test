<h1>Список городов</h1>

<form id="cityFilterForm" method="get">
    <label>
        <input type="checkbox" data-filter="country">
        Название страны:
        <input type="text" name="filter[country]" value="<?= htmlspecialchars($_GET['filter']['country'] ?? '') ?>">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="city">
        Название города:
        <input type="text" name="filter[city]" value="<?= htmlspecialchars($_GET['filter']['city'] ?? '') ?>">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="id">
        ID:
        <input type="text" name="filter[id]" value="<?= htmlspecialchars($_GET['filter']['id'] ?? '') ?>">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" <?= ($_GET['sort'] ?? '') === 'id' ? 'selected' : '' ?>>Сортировать по ID</option>
        <option value="country" <?= ($_GET['sort'] ?? '') === 'country' ? 'selected' : '' ?>>Сортировать по названию страны</option>
        <option value="city" <?= ($_GET['sort'] ?? '') === 'city' ? 'selected' : '' ?>>Сортировать по названию города</option>
    </select>

    <select name="order">
        <option value="asc" <?= ($_GET['order'] ?? '') === 'asc' ? 'selected' : '' ?>>По возрастанию</option>
        <option value="desc" <?= ($_GET['order'] ?? '') === 'desc' ? 'selected' : '' ?>>По убыванию</option>
    </select>

    <button type="submit">Фильтровать</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Название страны</th>
        <th>Название города</th>
    </tr>
    {% foreach city in cities %}
    <tr>
        <td>{{ city.id }}</td>
        <td>{{ city.country }}</td>
        <td>{{ city.city }}</td>
    </tr>
    {% endforeach %}
</table>

<script>
    document.getElementById('cityFilterForm').addEventListener('submit', function (e) {
        const form = e.target;
        const checkboxes = form.querySelectorAll('input[type=checkbox][data-filter]');

        checkboxes.forEach(checkbox => {
            const fieldName = checkbox.dataset.filter;
            const input = form.querySelector(`[name="filter[${fieldName}]"]`);

            if (!checkbox.checked) {
                if (input) input.disabled = true;
                checkbox.disabled = true;
            }
        });
    });
</script>
