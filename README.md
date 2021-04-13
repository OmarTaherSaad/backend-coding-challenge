# About The Application

##### This is a simple web application, built with [Laravel](https://laravel.com) 8, and have no front-end as it is not needed.

It is a REST microservice that list the languages used by the 100 trending public repos on GitHub.
For every language, you will find:
- Number of repos using this language
- The list of repos using the language (Name & URL)

# How to Get Results
You just need to clone this repo on your local machine and run "composer install", or deploy it onto a live server.
To get the results, you should call this url with GET method:
```
https://[Your-URL]/api/trending-languages
```

It will return json with two keys:
-  **success**: which is true or false.
-  **languages**: list of languages as key => value, where the "key" is language name, and "value" contains:
        -  count: count of repos using this language.
        -  repos: name & url of these repos.

## License

This Application is open-source, licensed under the [MIT license](https://opensource.org/licenses/MIT).
