from app import db


class Entry(db.Model):
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    timestamp = db.Column(db.DateTime)
    sip = db.Column(db.String(16))
    method = db.Column(db.String(10))
    uri = db.Column(db.Text)
    query = db.Column(db.Text)
    sport = db.Column(db.Integer)
    username = db.Column(db.String(256))
    cip = db.Column(db.String(16))
    useragent = db.Column(db.Text)
    referer = db.Column(db.Text)
    status = db.Column(db.Text)
    substatus = db.Column(db.Text)
    win32status = db.Column(db.Text)
    timetaken = db.Column(db.Text)
    country = db.Column(db.String(128))

    def __repr__(self):
        return '<Entry: {}>'.format(self.cip)


class Attack(db.Model):
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    entry_id = db.Column(db.Integer, db.ForeignKey('entry.id'))
    entry = db.relationship('Entry', backref=db.backref('attacks', lazy=True))
    ip = db.Column(db.String(16))
    type = db.Column(db.String(10))
    country = db.Column(db.String(128))

    def __repr__(self):
        return '<Attack: {} - {}>'.format(self.ip, self.type)
