# Sincronizar GitHub con FTP ASDFASDF FUNCIONOOOOO

Cómo versionar con **Git/GitHub** y opciones para desplegar por FTP desde GitHub Actions.

---

## 1. Deploy automático por FTP desde GitHub

Si tu servidor solo tiene **FTP** y querés que GitHub suba los archivos automáticamente, usá **GitHub Actions**.

### Workflow de ejemplo: `.github/workflows/deploy.yml`

```yaml
name: Deploy FTP

on:
    push:
        branches:
            - main

jobs:
    ftp-deploy:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v3
            - name: Deploy via FTP
              uses: SamKirkland/FTP-Deploy-Action@v4.3.5
              with:
                  server: ${{ secrets.FTP_SERVER }}
                  username: ${{ secrets.FTP_USER }}
                  password: ${{ secrets.FTP_PASS }}
                  protocol: ftps
                  server-dir: /public_html/mi-proyecto/
                  local-dir: ./
                  exclude: |
                      **/.git*
                      **/.github/**
                      **/node_modules/**
                      **/*.md
```

### Agregar secretos en GitHub

Repo → Settings → Secrets and variables → Actions:

-   `FTP_SERVER` (ej: ftp.tuservidor.com)
-   `FTP_USER`
-   `FTP_PASS`

> Consejo: si tenés acceso SSH al servidor, es preferible usar un deploy por SSH / git hooks en el servidor: es más seguro y rápido.

---
