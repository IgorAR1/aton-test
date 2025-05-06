<h1>Список пользователей</h1>

<form id="userFilterForm" method="get">
    <label>
        <input type="checkbox" data-filter="first_name">
        Имя:
        <input type="text" name="filter[first_name]" value="<?= htmlspecialchars($_GET['filter']['first_name'] ?? '') ?>">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="last_name">
        Фамилия:
        <input type="text" name="filter[last_name]" value="<?= htmlspecialchars($_GET['filter']['last_name'] ?? '') ?>">
    </label>
    <br>

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

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" <?= ($_GET['sort'] ?? '') === 'id' ? 'selected' : '' ?>>По ID</option>
        <option value="country" <?= ($_GET['sort'] ?? '') === 'country' ? 'selected' : '' ?>>По названию страны</option>
        <option value="city" <?= ($_GET['sort'] ?? '') === 'city' ? 'selected' : '' ?>>По названию города</option>
        <option value="name" <?= ($_GET['sort'] ?? '') === 'name' ? 'selected' : '' ?>>По фамилии + имени</option>
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
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Название страны</th>
        <th>Название города</th>
    </tr>
    {% foreach user in users %}
    <tr>
        <td>{{ user.id }}</td>
        <td>{{ user.last_name }}</td>
        <td>{{ user.first_name }}</td>
        <td>{{ user.country }}</td>
        <td>{{ user.city }}</td>
    </tr>
    {% endforeach %}
</table>

<script>
    document.getElementById('userFilterForm').addEventListener('submit', function (e) {
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
