---
Description:
---

Arguments must be passed as {arg1} or {arg2,arg3} or {arg4} {arg5}

Options must be passed as [opt1=value1] or [opt2={value21,value22}

---
Requirements:
---

PHP 8.1+

---
Install:
---

**Creating command**

Create the file of command. Provide name and description:
```
namespace App\Command;

use sklwebdev\Console\Command\Command as BaseCommand;
use sklwebdev\Console\Input;
use sklwebdev\Console\Output;

class MyCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function execute(Input\InputInterface $input, Output\OutputInterface $output)
    {
        // Put your logic here...
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        // Command name
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        // Command description
    }
}
```

**Register your command**

If you don`t have a registry loader, please create it and register your command:
```
namespace App\Registry;

use App\Command\MyCommand;
use sklwebdev\Console\Registry;

class MyLoader implements Registry\LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(): Registry\Registry
    {
        $registry = new Registry\Registry();
        
        // Register new command
        $register
            ->add(new MyCommand());

        return $registry;
    }
}
```

**Create console PHP file**

Create console application file (app.php):
```
require __DIR__.'/vendor/autoload.php';

use App\Registry;
use sklwebdev\Console\Application;
use sklwebdev\Console\Input;
use sklwebdev\Console\Output;

$input = new Input\ArgvInput($argv);
$output = new Output\ConsoleOutput();

$loader = new Registry\MyLoader();  // <-- Your created loader

$app = new Application($loader);
$app->run($input, $output);
```

---
Usage:
---

Example:
```
php app.php %command_name% {verbose,overwrite} [log_file=app.log] {unlimited} [methods={create,update,delete}] [paginate=50] {log}
```
where,

app.php - file name created during installation section

%command_name% - name of command to run
