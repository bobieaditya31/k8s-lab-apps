# =========================
# STAGE 1: dependencies
# =========================
FROM node:20.11-alpine AS deps

WORKDIR /app

COPY package*.json ./
RUN npm ci --only=production

# =========================
# STAGE 2: build
# =========================
FROM node:20.11-alpine AS builder

WORKDIR /app

COPY --from=deps /app/node_modules ./node_modules
COPY . .

ARG VERSION=dev
ENV APP_VERSION=$VERSION

RUN npm run build

# =========================
# STAGE 3: runtime
# =========================
FROM nginx:alpine

COPY --from=builder /app/.next /usr/share/nginx/html
COPY --from=builder /app/public /usr/share/nginx/html

EXPOSE 80