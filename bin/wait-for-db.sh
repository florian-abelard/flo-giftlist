#!/bin/sh

while ! nc -z 192.168.1.13 5432; do
  echo >&2 "$(date +%T) Postgres is unavailable - sleeping"
  sleep 1
done

echo >&2 "$(date +%T) Postgres is up"
