# Build a live customer app with Chatkit, Symfony and Vue - Part 1: Setting up the project

This is a demo application showing how to build a live customer support application using Symfony, Chatkit and Vue. You can read the tutorial on how it was built [here](https://pusher.com/tutorials/live-customer-support-symfony-vue-part-1)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Requirement

This application uses the following:

- PHP version 7.1 or higher
- Symfony version 4.1
- Composer  (You can get the latest version) 
- Vue.js version 2.x
- Node.js version 8.9 or above
- Yarn version 1.7.0 or higher
- You also need a Chatkit account. [Register](https://dash.pusher.com/authenticate/register?product=chatkit) an account if you don't have one already, otherwise [log](https://dash.pusher.com/authenticate) into your dashboard. Once, you are logged in, grab your `CHATKIT_INSTANCE_LOCATOR` and `CHATKIT_KEY` keys from the *Credentials* tab.

### Setting up the project

 - Clone this repository to your local machine:

```sh
 $ git clone -b part-one https://github.com/dongido001/live-customer-support.git
```

 - Update the following keys in the `.env` file with your correct Pusher keys:
  ```
    CHATKIT_INSTANCE_LOCATOR=YOUR_CHATKIT_INSTANCE_LOCATOR
    CHATKIT_KEY=YOUR_CHATKIT_SECRET_KEY
  ```

Make sure to replace `YOUR_CHATKIT_INSTANCE_LOCATOR` and `YOUR_CHATKIT_SECRET_KEY` placeholders with their actual values.

- Update the Instance Location key in config.js
  
  ```
    export default {
        instanceLocator: 'YOUR_CHATKIT_INSTANCE_LOCATOR',
    }
   ```

- Install the frontend packages:
   ```
    yarn install
   ```

- Start the frontend server:

    ```
        yarn encore dev-server --hot
    ```

- Install backend packages

    ```
    composer install
    ```

- Open a new terminal and start up the Backend server:

  ```
    php -S localhost:9030 -t public

  ```
You can now access the application from http://localhost:9030


## Built With

* [Symfony](https://symfony.com/) - Modern PHP framework
* [Chatkit](https://pusher.com/chatkit) - EXTENSIBLE API TO
FORM BUILDING IN-APP MESSAGING.
* [Vue](https://vuejs.org/) - Front-end framework for building user interfaces.
