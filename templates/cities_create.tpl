<h1>Create city</h1>
<form method="post">
    <label>
        Country:

        {% if isset($errors) %}
            {% foreach error in errors %}
            <li style="color: red">{{ error }}</li>
            {% endforeach %}
        {% endif %}
        <input type="text" name="city" placeholder="City">
        <select name="country_id">
            {% foreach country in countries %}
                <option value={{ country.id }}>{{ country.country }}</option>
            {% endforeach %}
        </select>
    </label>
    <input type="submit">
</form>
