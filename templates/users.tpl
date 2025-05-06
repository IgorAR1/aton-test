<h1>Список пользователей</h1>

<form method="get">
    <input type="text" name="name" placeholder="Имя или фамилия" value="{{ filters.name }}">
    <input type="text" name="location" placeholder="Страна или город" value="{{ filters.location }}">
    <input type="text" name="id" placeholder="ID" value="{{ filters.id }}">
    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" {{ sort == 'id' ? 'selected' : '' }}>По ID</option>
        <option value="name" {{ sort == 'name' ? 'selected' : '' }}>По имени</option>
        <option value="country" {{ sort == 'country' ? 'selected' : '' }}>По стране</option>
        <option value="city" {{ sort == 'city' ? 'selected' : '' }}>По городу</option>
    </select>
    <button type="submit">Фильтровать</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Страна</th>
        <th>Город</th>
    </tr>
    {% foreach user in users %}
    <tr>
        <td>{{ user.id }}</td>
        <td>{{ user.full_name }}</td>
        <td>{{ user.country }}</td>
        <td>{{ user.city }}</td>
    </tr>
    {% endforeach %}
</table>
