<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form Component</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
  <login-form></login-form>

  <script>
    const sharedClasses = {
      inputContainer: 'flex items-center bg-green-300 rounded-full px-4 py-2',
      inputIcon: 'fas fa-user text-green-700',
      inputField: 'bg-transparent flex-1 ml-2 outline-none',
      checkboxLabel: 'inline-flex items-center text-green-200 text-sm',
      button: 'w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-full transition-colors',
      link: 'text-sm text-green-200 hover:underline',
    };

    const LoginForm = () => {
      return `
        <div class="w-full max-w-sm mx-auto bg-green-600 rounded-lg p-8">
          <h1 class="text-white text-3xl font-bold mb-2">Welcome</h1>
          <p class="text-green-200 text-sm mb-8">Login to your account</p>
          <form>
            ${UsernameInput()}
            ${PasswordInput()}
            ${RememberMeCheckbox()}
            <button type="submit" class="${sharedClasses.button}"><a href="/">Login</a></button>
          </form>
          <p class="text-center text-green-200 text-sm mt-4">
            Haven't had an Account? <a href="/signup" class="text-white ${sharedClasses.link}">Sign Up</a>
          </p>
        </div>
      `;
    };

    const UsernameInput = () => {
      return `
        <div class="mb-4">
          <label class="block text-green-200 text-sm mb-2" for="username">Username</label>
          <div class="${sharedClasses.inputContainer}">
            <i class="${sharedClasses.inputIcon}"></i>
            <input type="text" id="username" name="username" class="${sharedClasses.inputField}" placeholder="username">
          </div>
        </div>
      `;
    };

    const PasswordInput = () => {
      return `
        <div class="mb-6">
          <label class="block text-green-200 text-sm mb-2" for="password">Password</label>
          <div class="${sharedClasses.inputContainer}">
            <i class="fas fa-lock text-green-700"></i>
            <input type="password" id="password" name="password" class="${sharedClasses.inputField}" placeholder="Password">
          </div>
        </div>
      `;
    };

    const RememberMeCheckbox = () => {
      return `
        <div class="flex items-center justify-between mb-6">
          <label class="${sharedClasses.checkboxLabel}">
            <input type="checkbox" class="form-checkbox text-green-500">
            <span class="ml-2">Remember me</span>
          </label>
          <a href="#" class="${sharedClasses.link}">Forgot Password?</a>
        </div>
      `;
    };

    customElements.define('login-form', class extends HTMLElement {
      connectedCallback() {
        this.innerHTML = LoginForm();
      }
    });
  </script>
</body>
</html>