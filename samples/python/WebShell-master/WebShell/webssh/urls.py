from django.urls import path
from webssh.views import webshell
app_name = 'webssh'
urlpatterns = [
    path('', webshell, name='webshell'),

    ]
