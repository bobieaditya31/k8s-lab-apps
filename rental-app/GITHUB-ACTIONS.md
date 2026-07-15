# GitHub Actions CI/CD Pipeline

Panduan setup GitHub Actions untuk otomatis build dan push Docker image ke registry.

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Prerequisites](#prerequisites)
3. [Setup GitHub Secrets](#setup-github-secrets)
4. [Workflows](#workflows)
5. [Monitoring](#monitoring)
6. [Troubleshooting](#troubleshooting)

## Overview

Aplikasi ini dilengkapi dengan GitHub Actions workflows untuk:
- ✅ **Otomatis Build Docker Image** saat ada push ke main/develop
- ✅ **Push ke GitHub Container Registry (GHCR)** 
- ✅ **Push ke Docker Hub** (optional)
- ✅ **Run Tests** pada PostgreSQL container
- ✅ **Deploy ke Server** (optional)
- ✅ **Generate Image Tags** berdasarkan git tags dan branches

## Prerequisites

### 1. GitHub Repository Setup

Pastikan repository sudah di-push ke GitHub:

```bash
cd vehicle-rental-app
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/vehicle-rental-app.git
git push -u origin main
```

### 2. Docker Setup (untuk lokal testing)

```bash
docker -v          # Docker harus terinstall
docker-compose -v  # Docker Compose harus terinstall
```

### 3. GitHub Permissions

Repository harus memiliki:
- Settings → Actions → Permissions: "Read and write permissions"
- Settings → Actions → Workflow permissions: "Allow GitHub Actions to create and approve pull requests"

## Setup GitHub Secrets

### A. Docker Hub (Optional - untuk push ke Docker Hub)

**Langkah 1: Generate Docker Hub Token**

1. Login ke [Docker Hub](https://hub.docker.com/)
2. Klik Profile → Account Settings → Security
3. Klik "New Access Token"
4. Buat token dengan nama: `github-actions`
5. Copy token yang dihasilkan

**Langkah 2: Add ke GitHub Secrets**

1. Repository → Settings → Secrets and variables → Actions
2. Klik "New repository secret"
3. Tambahkan 2 secrets:

| Name | Value |
|------|-------|
| `DOCKERHUB_USERNAME` | username Docker Hub Anda |
| `DOCKERHUB_TOKEN` | token yang sudah di-generate |

### B. Server Deployment (Optional - untuk auto deploy)

Jika ingin auto-deploy ke server:

1. Repository → Settings → Secrets and variables → Actions
2. Tambahkan secrets:

| Name | Value |
|------|-------|
| `DEPLOY_HOST` | IP/hostname server |
| `DEPLOY_USER` | SSH username |
| `DEPLOY_KEY` | Private SSH key (full content) |
| `DEPLOY_PATH` | Path ke folder aplikasi di server |

**Cara generate SSH key:**
```bash
ssh-keygen -t rsa -b 4096 -f deploy_key
# Jangan pakai passphrase (tekan Enter)
cat deploy_key  # Copy ke DEPLOY_KEY secret
cat deploy_key.pub  # Add ke ~/.ssh/authorized_keys di server
```

## Workflows

### 1. Build and Push to GHCR (`.github/workflows/build-push.yml`)

**Trigger:**
- Push ke `main` atau `develop` branch
- Push git tags (v1.0.0, dll)
- Pull request

**Actions:**
1. Checkout code
2. Setup Docker Buildx
3. Login ke GitHub Container Registry
4. Build dan push image ke GHCR
5. Run tests pada PostgreSQL
6. Deploy ke server (jika ada secrets)

**Image Tags yang dihasilkan:**
```
ghcr.io/USERNAME/vehicle-rental-app:main
ghcr.io/USERNAME/vehicle-rental-app:v1.0.0
ghcr.io/USERNAME/vehicle-rental-app:sha-abc123def
```

### 2. Build and Push to Docker Hub (`.github/workflows/docker-hub.yml`)

**Trigger:**
- Push ke `main` branch
- Push git tags

**Actions:**
1. Checkout code
2. Setup Docker Buildx
3. Login ke Docker Hub
4. Build dan push image

**Image Tags yang dihasilkan:**
```
USERNAME/vehicle-rental-app:latest
USERNAME/vehicle-rental-app:main
USERNAME/vehicle-rental-app:v1.0.0
USERNAME/vehicle-rental-app:sha-abc123def
```

## Monitoring

### 1. View Workflow Runs

1. Repository → Actions
2. Pilih workflow yang ingin dilihat
3. Klik run untuk melihat detail

### 2. View Build Logs

```
Actions → [Workflow Name] → [Run] → [Job] → [Step]
```

### 3. Check Published Images

**Di GitHub Container Registry:**
```bash
docker pull ghcr.io/USERNAME/vehicle-rental-app:latest
```

**Di Docker Hub:**
```bash
docker pull USERNAME/vehicle-rental-app:latest
```

## Workflow Examples

### Push Image Otomatis ke Main Branch

```bash
# 1. Buat perubahan
git add .
git commit -m "Update feature"

# 2. Push ke main
git push origin main

# 3. GitHub Actions otomatis:
#    - Build Docker image
#    - Push ke GHCR
#    - Push ke Docker Hub (jika ada DOCKERHUB_TOKEN)
#    - Run tests
#    - Deploy ke server (jika ada DEPLOY_KEY)
```

### Release dengan Git Tags

```bash
# 1. Buat tag
git tag v1.0.0
git push origin v1.0.0

# 2. GitHub Actions otomatis:
#    - Build image dengan tag v1.0.0
#    - Push ke semua registry
```

### Pull Request Testing

```bash
# 1. Create feature branch
git checkout -b feature/new-feature

# 2. Make changes & push
git push origin feature/new-feature

# 3. Create Pull Request
# 4. GitHub Actions otomatis test (tidak push image)
```

## Testing Workflows Lokal

### Test Docker Build

```bash
# Build production image
docker build -t vehicle-rental-app:latest .

# Test container
docker run -p 8080:80 vehicle-rental-app:latest

# Akses http://localhost:8080
```

### Test dengan Docker Compose

```bash
docker-compose up --build
# Akses http://localhost:8080
# Database UI: http://localhost:8081
```

### Test Image dari Registry

```bash
# Pull dari GHCR
docker pull ghcr.io/USERNAME/vehicle-rental-app:latest

# Pull dari Docker Hub
docker pull USERNAME/vehicle-rental-app:latest

# Run
docker run -p 8080:80 ghcr.io/USERNAME/vehicle-rental-app:latest
```

## Troubleshooting

### GitHub Actions gagal build

**Error: "No DOCKERHUB_TOKEN"**
- Solution: Add `DOCKERHUB_USERNAME` dan `DOCKERHUB_TOKEN` di GitHub Secrets
- Atau gunakan `if: ${{ secrets.DOCKERHUB_TOKEN != '' }}` untuk skip Docker Hub push

**Error: "Permission denied"**
- Solution: Pastikan workflow file ada di `.github/workflows/`
- Check syntax YAML

**Error: "Build failed"**
- Solution: 
  1. Check workflow logs di Actions tab
  2. Jalankan docker build lokal: `docker build .`
  3. Fix errors dan push ulang

### Docker Image tidak push

**Images hanya build, tidak push**
- Pastikan push key ada: `push: ${{ github.event_name == 'push' }}`
- Buat push ke main branch: `git push origin main`

**Image push tapi tag tidak benar**
- Check metadata action di workflow
- Verifikasi git tags: `git tag --list`

### Deploy gagal

**Error: "SSH connection failed"**
- Solusi:
  1. Verify DEPLOY_HOST, DEPLOY_USER, DEPLOY_KEY
  2. Test SSH lokal: `ssh -i deploy_key user@host`
  3. Ensure server dapat diakses dari GitHub runners

**Error: "docker-compose: command not found"**
- SSH ke server dan install Docker Compose:
  ```bash
  curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  chmod +x /usr/local/bin/docker-compose
  ```

## Advanced Configuration

### Skip Workflow pada Commit Tertentu

```bash
# Tambahkan di commit message
git commit -m "Update docs [skip ci]"
git push
# Workflow tidak akan run
```

### Manual Trigger Workflow

1. Actions → [Workflow] → "Run workflow" button
2. Pilih branch
3. Klik "Run workflow"

### Conditional Steps

Workflow sudah support:
- Push ke GHCR: Always (semua event)
- Push ke Docker Hub: Hanya saat `push` event ke `main`
- Deploy: Hanya saat `push` event ke `main` + ada DEPLOY_KEY

## Tips & Best Practices

1. **Use Semantic Versioning**
   ```bash
   git tag v1.0.0
   git tag v1.0.1
   git tag v1.1.0
   ```

2. **Commit Messages**
   ```bash
   git commit -m "feat: add new feature"
   git commit -m "fix: fix bug"
   git commit -m "docs: update documentation"
   ```

3. **Branch Strategy**
   ```
   main (production)
   ├─ release branches (v1.0.x)
   └─ develop (development)
   ```

4. **Review Before Merge**
   ```bash
   - Create Pull Request
   - Wait for Actions to complete
   - Review changes
   - Merge ke main
   ```

---

## Example: Complete Setup Flow

```bash
# 1. Clone & Setup
git clone https://github.com/YOUR_USERNAME/vehicle-rental-app.git
cd vehicle-rental-app

# 2. Add GitHub Secrets
# Repository → Settings → Secrets and variables → Actions
# - DOCKERHUB_USERNAME
# - DOCKERHUB_TOKEN
# - (DEPLOY_HOST, DEPLOY_USER, DEPLOY_KEY - optional)

# 3. Make Changes
echo "Updated code" >> README.md
git add .
git commit -m "feat: update readme"

# 4. Push & Trigger Workflow
git push origin main
# GitHub Actions otomatis run!

# 5. Monitor
# Go to: Repository → Actions
# Lihat workflow running & building

# 6. Release
git tag v1.0.0
git push origin v1.0.0
# Image dengan tag v1.0.0 otomatis push ke semua registry
```

---

**Dokumentasi GitHub Actions selesai! 🚀**

Untuk detail lebih lanjut:
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Docker Build Action](https://github.com/docker/build-push-action)
- [GitHub Container Registry](https://docs.github.com/en/packages/working-with-a-github-packages-registry/working-with-the-container-registry)
