<h1>Local installation guide for Symfony project</h1>
<h3>Requirements</h3>
Make sure you have the following programs installed on your computer.
<ol>
  <li>Required programs
<ul>
  <li>PHP</li>
  <li>Composer</li>
  <li>MySQL</li>
  <li>Git</li>  
  <li>Symfony CLI</li>
  </li>
  </ul>
<li>Verify installations
<ul>
  <li>Check your PHP version: <code>php -v</code></li>
  <li>Check your Composer version: <code>composer --version</code></li>
  <li>Test MySQ connection: <code>mysql -u root -p</code></li>
    
  </li>
  </ul>
</ol>

<h3>Setup instructions</h3>
<ol>
  <li><strong>Clone the repository</strong>
    <p>Clone the project to your computer using Git:<br><code>git clone https://github.com/username/repository.git</code></p>
  </li>
  <li><strong>Install dependencies</strong>
  <p>Navigate to the project directory:<br><br><code>cd project-name</code></p>
  <p><code>composer install</code></p>
  </li>
  <li><strong>Set up the database</strong>
    <p>Log in to mySQL and create a database for the project.</p>
    <p>Configurate the <code>.env</code> file:<span>
      Open the <code>.env</code> file in the root directory of the project and make changes
    </span><br>
      <code>DATABASAE_URL="mysql://root:password@localhost:3306/database_name"</code>
    </p>
  </li>
  <li>
    <strong>Run migrations</strong>
    <p><code>php bin/console doctrine:migrations:migrate</code></p>
  </li>
  <li>
    <strong>Start the Symfony Server</strong>
    <br>
    <code>symfony server:start</code>
  </li>
  <li><strong>Open the project in a browser</strong>
    <br>
    <code>http://127.0.0.1:8000</code>
  </li>

  <h2>Documentation</h2>
  <p>This is TODO APP built with Symfony v6.4.It allows user to create,manage and track their tasks.</p>

  <h3>Components</h3>
  <strong>Controllers</strong>
  <p><strong>TodoController</strong></p>
  <p>Routes:</p>
  <p><code>/todo/list</code>:Display all tasks.</p>
  <p><code>/todo/create</code>:Form to create a new task.</p>
  <p><code>/todo/{id}/delete</code>:Delete specific task.</p>
  <p><code>/todo/{id}/toggle-finished</code>:Toggle task completion status</p>
  <p><strong>SecurityController</strong></p>
  <p>Routes:</p>
  <p><code>/</code>:Display Log in form</p>
  <p><code>/logout</code>Logs out the user</p>
  <p><strong>RegistrationController</strong></p>
  <p>Routes:</p>
  <p><code>/register</code>:Display register form</p>
  <strong>Entities</strong>
  <p><strong>User</strong></p>
  <code>Id</code>
  <code>Email</code>
  <code>Password</code>
  <code>Role</code>
  <p><strong>Todo</strong></p>
  <code>Title</code>
  <code>Description</code>
  <code>isFinished</code>
  <code>user_id</code>
  <code>dueDate</code>
<h3>Workflow</h3>
<ul>
  <li>User Registration and Login
    <ul>
<li>User must register and log in to acces the application.</li>    
    </ul>
  </li>
  <li>Task Management
    <ul>
  <li>Users can add new tasks,set deadline and mark tasks as finished.</li>
  <li>Tasks can be deleted when no longer needed.</li> 
    </ul>
    </li>
  <li>Security
    <ul>
  <li>Users can only view and manage tasks that belong to their account.</li>
  <li>Password are securely hashed for user safety.</li>
    </ul>
    </li>
</ul>
  
  

  

