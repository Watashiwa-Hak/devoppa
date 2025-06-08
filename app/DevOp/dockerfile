# Start from Ubuntu 24.04
FROM ubuntu:24.04

# Set environment variables to noninteractive
ENV DEBIAN_FRONTEND=noninteractive

# Install Nginx, git, curl, and other dependencies
RUN apt-get update \
    && apt-get install -y \
        nginx \
        git \
        curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Remove the default /var/www/html directory
RUN rm -rf /var/www/html

# Clone the website template from GitHub to /var/www/html
RUN git clone https://github.com/yenchiah/project-website-template.git  /var/www/html

# Set permissions for the cloned directory
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Nginx in the foreground
CMD ["nginx", "-g", "daemon off;"]