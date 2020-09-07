# Installation

#### Backend 

**Step 1:** Open CMD and run command

`$ git clone https://github.com/sgflores/simple-banking-app.git`

**Step 2:** Move into the new folder  `simple-banking-app` 

`$ cd simple-banking-app`

**Step 3:** Go to api folder and install dependencies. 

`$ cd api`

`$ composer install`

**Step 4:** Next, create a .env file at the root of the api project and populate it with the content found in the .env.example file.

`$ cp .env.example .env`

**Step 5:** Then generate the application key for this project 

`$ php artisan key:generate`

**Step 6:** Now lets run our migrations and seeders

`$ php artisan migrate --seed`

`$ php artisan passport:install`

**Step 7:** After passport is installed a personal access client will be generated. Please take note of the `Client ID` and `Client Secret`. We will use this in our frontend

**Step 7:** Finally lets run our backend

`$ php artisan serve`

**Step 8:** Our backend api should be accessible in http://127.0.0.1:8000

### FronteEnd
Now after the backend setup is done lets move to the frontend

**Step 1:** Navigate to web folder

`$ cd ../web`

**Step 2:** Install dependencies

`$ npm install` or `$ yarn install`

**Step 3:** Create .env file at the root of the web project and populate it with the content found in the .env.example file.

`$ cp .env.example .env`

**Step 4:** After .env file has been created the next step is to update our client credentials. These credentials has been generated from passport installation in the backend. It may look something like this

`grant_type=client_credentials`
`client_id=1`
`client_secret=***`

**Step 5:** Lets run our web project

`$ npm run dev` or `yarn run dev`

**Step 6:** Now we can access the web in this url 

`http://localhost:3000/`