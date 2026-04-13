pipeline {
  agent any

  environment {
    IMAGE = "bobieaditya03/myapp"
    TAG = "v${BUILD_NUMBER}"
    GITOPS_REPO = "https://github.com/bobieaditya31/k8s-lab-infra.git"
  }

  stages {

    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Build Image') {
      steps {
        dir('demo-apps01') {
          sh "docker build -t ${IMAGE}:${TAG} ."
        }
      }
    }

    stage('Push Image') {
      steps {
        withCredentials([usernamePassword(
          credentialsId: 'dockerhub-credentials',
          usernameVariable: 'USER',
          passwordVariable: 'PASS'
        )]) {
          sh """
          echo $PASS | docker login -u $USER --password-stdin
          docker push ${IMAGE}:${TAG}
          """
        }
      }
    }

    stage('Update GitOps Repo') {
      steps {
        withCredentials([usernamePassword(
          credentialsId: 'github-credentials',
          usernameVariable: 'GIT_USER',
          passwordVariable: 'GIT_PASS'
        )]) {

          sh """
          rm -rf gitops
          git clone https://${GIT_USER}:${GIT_PASS}@github.com/bobieaditya31/k8s-lab-infra.git gitops

          cd gitops/applications/myapp

          # update tag
          sed -i "s/tag:.*/tag: ${TAG}/" values.yaml

          git config user.email "jenkins@local"
          git config user.name "jenkins"

          git add .
          git commit -m "update image to ${TAG}" || echo "no changes"
          git push
          """
        }
      }
    }
  }

  post {
    success {
      echo "✅ CI/CD SUCCESS"
    }
    failure {
      echo "❌ CI/CD FAILED"
    }
  }
}