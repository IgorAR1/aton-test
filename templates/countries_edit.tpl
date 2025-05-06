<h1>Edit {{ country.country }} </h1>

<form method="post" action="">
    <label>
        Country:
        {% if isset($errors) %}
            {% foreach error in errors %}
                <li style="color: red">{{ error }}</li>
            {% endforeach %}
        {% endif %}

        <input type="text" name="country" value="{{ country.country }}">
    </label>
    <input type="submit" value="Edit">
</form>