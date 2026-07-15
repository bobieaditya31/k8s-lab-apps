# CI/CD Pipeline dengan GitHub Actions

Panduan quick start untuk setup GitHub Actions agar code otomatis di-build menjadi Docker image dan push ke registry.

## 🚀 Quick Start (5 Menit)

### 1. Push Code ke GitHub

```bash
# Jika belum
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/vehicle-rental-app.git
git push -u origin main
```

### 2. Setup Docker Hub (Jika ingin push ke Docker Hub)

**A. Buat Docker Hub Account**
- Kunjungi [Docker Hub](https://hub.docker.com/)
- Register/Login

**B. Generate Access Token**
- Login ke Docker Hub
- Profile → Account Settings → Security
- Klik "New Access Token"
- Nama: `github-actions`
- Copy token

**C. Add ke GitHub**
- Repository → Settings → Secrets and variables → Actions
- Klik "New repository secret"
- Buat 2 secrets:
  ```
  Name: DOCKERHUB_USERNAME
  Value: YOUR_DOCKERHUB_USERNAME
  
  Name: DOCKERHUB_TOKEN
  Value: YOUR_ACCESS_TOKEN
  ```

### 3. Trigger Workflow

```bash
# Push code
git add .
git commit -m "Trigger CI/CD"
git push origin main

# Workflow otomatis berjalan!
# Lihat di: Repository → Actions
```

### 4. Cek Image

**GitHub Container Registry (GHCR):**
```bash
docker pull ghcr.io/YOUR_USERNAME/vehicle-rental-app:latest
```

**Docker Hub:**
```bash
docker pull YOUR_DOCKERHUB_USERNAME/vehicle-rental-app:latest
```

## 📋 Workflow Tersedia

### `build-push.yml` - Build & Push ke GHCR

**Trigger:**
- Push ke `main` branch → Push ke GHCR + Run Tests
- Push ke `develop` branch → Build only
- Git tags (v1.0.0) → Push dengan version tag

**Output:**
```
ghcr.io/USERNAME/vehicle-rental-app:main
ghcr.io/USERNAME/vehicle-rental-app:v1.0.0
ghcr.io/USERNAME/vehicle-rental-app:sha-abc123
```

### `docker-hub.yml` - Build & Push ke Docker Hub

**Trigger:**
- Push ke `main` branch
- Git tags

**Output:**
```
USERNAME/vehicle-rental-app:latest
USERNAME/vehicle-rental-app:main
USERNAME/vehicle-rental-app:v1.0.0
```

## 📝 Contoh Workflow

### Example 1: Development Push

```bash
# 1. Edit code
echo "// new feature" >> app/Controllers/Home.php

# 2. Commit & Push
git add app/Controllers/Home.php
git commit -m "feat: add new feature"
git push origin main

# 3. GitHub Actions:
#    ✅ Build image
#    ✅ Push ke GHCR:main
#    ✅ Push ke Docker Hub:latest, Docker Hub:main
#    ✅ Run tests
```

### Example 2: Release dengan Version Tag

```bash
# 1. Create tag
git tag v1.0.0
git push origin v1.0.0

# 2. GitHub Actions:
#    ✅ Build image
#    ✅ Push ke GHCR:v1.0.0
#    ✅ Push ke Docker Hub:v1.0.0
```

### Example 3: Pull Request (Test Only)

```bash
# 1. Create branch
git checkout -b feature/new-feature
git push origin feature/new-feature

# 2. Create Pull Request di GitHub

# 3. GitHub Actions:
#    ✅ Build image (test)
#    ✅ Run tests
#    ❌ Tidak push (hanya test)
```

## 🔍 Monitor Progress

### View Workflow

1. Repository → Actions
2. Lihat list workflow runs
3. Klik run yang ingin dilihat
4. Lihat status setiap step

### View Build Logs

```
Actions 
  → [Workflow Name] 
    → [Run #]
      → [build-and-push job]
        → [Build and push step]
          → Lihat detailed logs
```

## 🐳 Test Image Lokal

### Pull dari GHCR

```bash
docker login ghcr.io
# Username: YOUR_GITHUB_USERNAME
# Password: YOUR_GITHUB_TOKEN (dengan read:packages permission)

docker pull ghcr.io/YOUR_USERNAME/vehicle-rental-app:latest
docker run -p 8080:80 ghcr.io/YOUR_USERNAME/vehicle-rental-app:latest
```

### Pull dari Docker Hub

```bash
docker login
# Username: YOUR_DOCKERHUB_USERNAME
# Password: YOUR_DOCKER_TOKEN

docker pull YOUR_DOCKERHUB_USERNAME/vehicle-rental-app:latest
docker run -p 8080:80 YOUR_DOCKERHUB_USERNAME/vehicle-rental-app:latest
```

## ⚙️ Advanced Setup

### Add SSH Deploy Secret (Untuk Auto Deploy)

Jika ingin auto-deploy ke VPS/Server:

```bash
# 1. Generate SSH key di local
ssh-keygen -t rsa -b 4096 -f deploy_key
# Tekan Enter (no passphrase)

# 2. Copy private key ke GitHub Secret
cat deploy_key  # Copy full content

# 3. Add di GitHub Secrets:
# DEPLOY_HOST: 123.45.67.89
# DEPLOY_USER: root
# DEPLOY_KEY: [paste full deploy_key content]
# DEPLOY_PATH: /home/app/vehicle-rental-app

# 4. Copy public key ke server
ssh-copy-id -i deploy_key.pub root@123.45.67.89
# atau manual: cat deploy_key.pub >> ~/.ssh/authorized_keys
```

### Custom Trigger pada Commit Message

```bash
# Skip workflow
git commit -m "Update docs [skip ci]"

# Trigger hanya tertentu
git commit -m "[deploy] Deploy ke production"
```

## 📊 Workflow Status Badge (Optional)

Add ke README.md untuk show build status:

```markdown
[![Build and Push](https://github.com/USERNAME/vehicle-rental-app/actions/workflows/build-push.yml/badge.svg)](https://github.com/USERNAME/vehicle-rental-app/actions/workflows/build-push.yml)

[![Build to Docker Hub](https://github.com/USERNAME/vehicle-rental-app/actions/workflows/docker-hub.yml/badge.svg)](https://github.com/USERNAME/vehicle-rental-app/actions/workflows/docker-hub.yml)
```

## 🆘 Troubleshooting

### Workflow tidak run

**Check:**
1. Apakah `.github/workflows/*.yml` ada di repository?
2. Apakah sudah push ke main branch?
3. Lihat Actions tab - apakah ada error?

**Fix:**
```bash
# Verify file ada
ls -la .github/workflows/

# Push ulang
git add .github/workflows/
git commit -m "Add GitHub Actions"
git push origin main
```

### Build failed

**Check logs:**
1. Repository → Actions
2. Klik workflow yang failed
3. Klik job → lihat error messages

**Common errors:**
- `DOCKERHUB_TOKEN not found` → Add secret ke GitHub
- `Docker build failed` → Test build lokal: `docker build .`
- `Test failed` → Check PostgreSQL connection

### Image tidak ter-push

**Check:**
1. Apakah workflow status SUCCESS?
2. Apakah branch = main?
3. Registry login berhasil?

**Fix:**
- GHCR: Otomatis (pakai GITHUB_TOKEN)
- Docker Hub: Perlu DOCKERHUB_TOKEN di secrets

## 🎯 Next Steps

1. ✅ Setup GitHub Secrets (Docker Hub credentials)
2. ✅ Push code ke GitHub
3. ✅ Trigger workflow (automatic saat push)
4. ✅ Monitor di Actions tab
5. ✅ Pull image dari registry
6. ✅ Deploy ke production (optional)

---

**Selesai! CI/CD pipeline sudah siap! 🎉**

Untuk detail lengkap: Baca file [GITHUB-ACTIONS.md](./GITHUB-ACTIONS.md)
