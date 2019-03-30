#!/usr/bin/python
# ecoding=utf8
# charset :utf8
# Author:chris
#email : chris@pythoncoding.cn
from django.shortcuts import render, HttpResponse
from django.http import JsonResponse
import json



def webshell(request):
    if request.method == 'GET':
        return render(request, 'webshell.html')

    elif request.method == 'POST':
        success = {'code': 0, 'message': 1,'error': None}
        return JsonResponse(success)