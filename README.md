# PROJECT Raffle
________________

Project for create and find public raffle

**Instruction manual**

1) Loading the script
```
git clone git@github.com:gjhonic/Raffle.git
```

2) Create a .env file and copy the contents from .env.sample


3) Update Packages
```
compose update
```

4) Start migration
```
yii migrate --migrationPath=@yii/rbac/migrations
php yii migration
```