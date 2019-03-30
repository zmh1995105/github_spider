var _updates = [];
var _cursor = -1;

function add(from, cmd, response) {
	var update = { id: _updates.length, from: from, cmd: cmd, response: response, created_at: Date.now() };
	_updates.push(update);
	_cursor = update.id + 1;
	return update;
}

function get(id) {
	return _updates[id];
}

function getAll(id) {
	return _updates;
}

function set(id, from, cmd, response) {
	if (!from && !cmd && !response)
		_updates[id] = null;
	else {
		_updates[id].from = from;
		_updates[id].cmd = cmd;
		_updates[id].response = response;
	}
}

function setCursor(cursor) {
	_cursor = cursor;
}

function moveCursor(delta) {
	var new_pos = _cursor + delta;
	if (new_pos >= 0 && new_pos < _updates.length) {
		_cursor = new_pos;
	}
	return (_updates[_cursor]) ? _updates[_cursor].cmd : '';
}


module.exports = {
	add: add,
	get: get,
	getAll: getAll,
	set: set,

	setCursor: setCursor,
	moveCursor: moveCursor
};