# -*- coding:utf-8 -*-
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.cluster import KMeans
from sklearn.externals import joblib

vectorizer = CountVectorizer()
corpus = [
    'usr local tomcat webapps upload test01.html',
    'usr local tomcat webapps upload test02.html',
    'usr local tomcat webapps upload test03.html',
    'usr local tomcat webapps log 20171108.log',
    'usr local tomcat webapps log 20171109.log',
    'usr local tomcat webapps log 20171110.log',]
# 样本转换为词频矩阵
X = vectorizer.fit_transform(corpus)
print X.toarray()
print vectorizer.get_feature_names()
print "\n"


# 计算词频矩阵中每个词语的tf-idf权值
transformer = TfidfTransformer()
tfidf = transformer.fit_transform(X.toarray())
print tfidf.toarray()
print "\n"


# 计算样本之间的余弦相似性
dist = 1 - cosine_similarity(tfidf)
print dist
print "\n"

# 自定义聚类的种类个数
num_cluster = 2

# 利用KMeans方法生成
km = KMeans(n_clusters=num_cluster)
km.fit(tfidf)
clusters = km.labels_.tolist()
print clusters

km = joblib.dump(km,'doc_cluster.pkl')
km = joblib.load('doc_cluster.pkl')
clusters = km.labels_.tolist()
print clusters