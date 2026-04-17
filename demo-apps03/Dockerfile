# ==========================================
# STAGE 1: Build dengan Bun
# ==========================================
FROM oven/bun:1-alpine AS builder

WORKDIR /build

# ⭐ COPY dari app/ folder
COPY app/package.json app/bun.lock ./

# Install dependencies
RUN bun install --frozen-lockfile

# ⭐ COPY semua dari app/
COPY app/ ./

# Build Next.js
ENV NEXT_TELEMETRY_DISABLED=1
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