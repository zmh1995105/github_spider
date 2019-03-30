from django.db import models
import django.utils.timezone as timezone


class webshell(models.Model):
    task_id = task_id = models.CharField(max_length=32)
    webshell_filepath = models.TextField()
    webshell_md5 = models.CharField(max_length=32)
    webshell_addtime = models.DateTimeField(auto_now_add=True)

class task(models.Model):
    task_id = models.CharField(max_length=32)
    task_name = models.TextField()
    task_filepath = models.CharField(max_length=32)
    task_status = models.CharField(max_length=7)
    task_addtime = models.DateTimeField(auto_now_add=True)
    task_finishtime = models.DateTimeField(default=timezone.now)
   
