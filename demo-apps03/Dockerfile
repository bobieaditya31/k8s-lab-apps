# ==========================================
# STAGE 1: Build dengan Bun
# ==========================================
FROM oven/bun:1-alpine AS builder

WORKDIR /build

# Copy semua file project
COPY package.json bun.lock ./
COPY next.config.ts tsconfig.json tailwind.config.ts postcss.config.mjs components.json ./
COPY src ./src
COPY public ./public

# Jika pakai Prisma
# COPY prisma ./prisma

# Install & build
RUN bun install --frozen-lockfile
RUN bun run build

# ==========================================
# STAGE 2: Production
# ==========================================
FROM oven/bun:1-alpine AS production

RUN addgroup -g 1001 -S nodejs && \
    adduser -S nextjs -u 1001

WORKDIR /app

# Copy standalone output
COPY --from=builder --chown=nextjs:nodejs /build/.next/standalone ./
COPY --from=builder --chown=nextjs:nodejs /build/.next/static ./.next/static
COPY --from=builder --chown=nextjs:nodejs /build/public ./public

USER nextjs

EXPOSE 3000

ENV PORT=3000
ENV HOSTNAME="0.0.0.0"

CMD ["bun", "server.js"]