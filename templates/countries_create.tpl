<h1>Create country</h1>

<form method="post">
    <label>
        Country:

        {% if isset($errors) %}
            {% foreach error in errors %}
                <li style="color: red">{{ error }}</li>
            {% endforeach %}
        {% endif %}
        <input type="text" name="country" placeholder="Country">
    </label>
    <input type="submit">
</form>