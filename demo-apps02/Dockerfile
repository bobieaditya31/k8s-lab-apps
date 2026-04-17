# ==========================================
# STAGE 1: Build Dependencies
# ==========================================
FROM node:18-alpine AS builder

WORKDIR /build

# Copy package files
COPY app/package*.json ./

# Install production dependencies only
RUN npm ci --only=production && \
    npm cache clean --force

# ==========================================
# STAGE 2: Production Image
# ==========================================
FROM node:18-alpine AS production

# Security: Run as non-root user
RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001

WORKDIR /app

# Copy dependencies from builder
COPY --from=builder /build/node_modules ./node_modules

# Copy application code
COPY --chown=nodejs:nodejs app/src ./src
COPY --chown=nodejs:nodejs app/public ./public
COPY --chown=nodejs:nodejs app/package.json ./

# Switch to non-root user
USER nodejs

# Expose port
EXPOSE 3000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD node -e "require('http').get('http://localhost:3000/health', (r) => {process.exit(r.statusCode === 200 ? 0 : 1)})"

# Start application
CMD ["node", "src/app.js"]