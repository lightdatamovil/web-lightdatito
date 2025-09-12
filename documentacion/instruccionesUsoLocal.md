# Levantar el frontend localmente (XAMPP + VirtualHost + Browsersync + Git)

Este documento explica **paso a paso** cómo levantar tu frontend localmente en Windows (XAMPP) usando VirtualHosts y cómo habilitar recarga en tiempo real con **Browsersync**.

> El proyecto esta en `C:\Users\Lightdata P54\Desktop\web-lightdatito`

---

## 0. Requisitos previos

-   XAMPP instalado y funcionando (Apache + PHP).
-   Acceso de administrador al equipo (para editar `hosts`).
-   Node.js + npm (para Browsersync).
-   Git (si vas a versionar y subir a GitHub).

---

## 1. Colocar el proyecto en tu PC

Decidí una carpeta para tus proyectos, por ejemplo:

```
C:\Users\Lightdata P54\Desktop\web-lightdatito
```

Podés mantenerlo allí o trabajar directamente en tu lugar preferido (no es obligatorio moverlo a `htdocs` si usás VirtualHost).

---

## 2. Configurar VirtualHost en XAMPP

1. Abrí `C:\xampp\apache\conf\extra\httpd-vhosts.conf` con un editor (Notepad++/VSCode) como administrador.
2. Al final del archivo agregá tu VirtualHost, por ejemplo:

```apache
<VirtualHost *:80>
    ServerName lightdatito.local
    DocumentRoot "C:\Users\Lightdata P54\Desktop\web-lightdatito"
    <Directory "C:\Users\Lightdata P54\Desktop\web-lightdatito">
        Options Indexes FollowSymLinks Includes ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Guardá los cambios.

> Asegurate que `httpd.conf` incluya `conf/extra/httpd-vhosts.conf` (por defecto XAMPP ya lo incluye, pero si lo editaste verifica que no esté comentado).

---

## 3. Añadir entrada al archivo `hosts`

1. Abrí **Bloc de notas** como Administrador.
2. Abrí el archivo `C:\Windows\System32\drivers\etc\hosts`.
3. Al final agregá (sin `#`):

```
127.0.0.1   lightdatito.local
```

4. Guardá el archivo. Si Windows no te deja guardar, asegurate de haber iniciado el editor como administrador.

---

## 4. Reiniciar Apache y probar

1. Desde el **XAMPP Control Panel**: parar Apache → iniciar Apache.
2. Abrí el navegador y andá a:

```
http://lightdatito.local
```

Si ves tu sitio, la VirtualHost funciona.

---

## 5. Habilitar recarga en tiempo real (Browsersync)

### Instalar Node.js

Si no tenés Node.js: descargá e instalá la versión LTS desde la web oficial.

### Agregar Browsersync al proyecto

En la carpeta del proyecto, abrí una terminal y ejecutá:

```bash
npm init -y
npm install --save-dev browser-sync
```

---

### Script npm recomendado

En `package.json` agregá el script `start` dentro de `"scripts": { ... }`:

```json
"scripts": {
  "start": "npx browser-sync start --proxy \"lightdatito.local\" --files \"**/*.php, **/*.css, **/*.js, **/*.png, **/*.jpg\" --no-open"
}
```

-   `--proxy "lightdatito.local"` hace que BrowserSync use tu VirtualHost.
-   `--files` define qué archivos vigilar.
-   `--no-open` evita que se abra una nueva ventana automáticamente (opcional).

### Ejecutar Browsersync

En la terminal:

```bash
npm start
```

Vas a ver algo como:

```
Local: http://localhost:3000
External: http://192.168.x.x:3000
```

Abrí `http://localhost:3000` y trabajá. Cada vez que guardes un archivo vigilado, el navegador se recargará.

---

## 6. Git & GitHub (subir el proyecto)

### Inicializar repo local

```bash
git init
git add .
git commit -m "Inicializar proyecto"
```

### Crear repo en GitHub

-   Crear repo vacío en GitHub.
-   Conectar remoto y pushear:

```bash
git remote add origin https://github.com/TU-USUARIO/mi-proyecto.git
git branch -M main
git push -u origin main
```

### `.gitignore` sugerido

```
node_modules/
.DS_Store
.env
.vscode/
.github/
```
