# -------------------------------------------------
# Dockerfile – static site dengan Nginx (alpine)
# -------------------------------------------------
FROM nginx:alpine

# Hapus konfigurasi default (opsional)
RUN rm /etc/nginx/conf.d/default.conf

# Salin konfigurasi Nginx minimal (optional – jika Anda ingin men‑custom)
# COPY nginx.conf /etc/nginx/conf.d/

# Salin semua berkas static ke folder yang dilayani Nginx
COPY app/ /usr/share/nginx/html/

# Expose port 80 (default di Nginx)
EXPOSE 80

# Nginx sudah dijalankan secara default via CMD