pipeline {
  agent any

  environment {
    IMAGE_NAME = "bobieaditya03/myapp"
    DOCKER_CREDS = "dockerhub-credentials"
  }

  stages {

    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Build Image') {
      steps {
        script {
          docker.build("${IMAGE_NAME}:v${BUILD_NUMBER}", ".")
        }
      }
    }

    stage('Push Image') {
      steps {
        script {
          docker.withRegistry('https://index.docker.io/v1/', DOCKER_CREDS) {
            def img = docker.image("${IMAGE_NAME}:v${BUILD_NUMBER}")
            img.push()
            img.push("latest")
          }
        }
      }
    }
  }

  post {
    success {
      echo "✅ Image pushed: v${BUILD_NUMBER}"
    }
  }
}