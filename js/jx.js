;
function jxFormData(p) {
	var list = {};
	jQuery('input[name], select[name], textarea[name]', p).each(function(i, v){
		var vj = jQuery(v);
		var n = vj.attr('name');
		var val = vj.val();
		var ismult = false;
		if (n.substr(-2) === '[]') {
			n = n.substr(0, n.length - 2);
			ismult = true;
		}
		if (vj.is('input[type="radio"]') || vj.is('input[type="checkbox"]')) {
			// Case 1 (radio or checkbox)
			if (vj.is(':checked')) {
				if (ismult) {
					if ((typeof list[n] === 'object') && (list[n] !== null)) {
						list[n].push(val);
					} else {
						list[n] = [val];
					}
				} else {
					list[n] = val;
				}
			} else {
				// Ignore
			}
		} else {
			if (vj.is('select[name]')) {
				if (ismult) {
					if (typeof val !== 'object') {
						list[n] = [val];
					} else {
						if (val === null) {
							// Pass it
						} else {
							if (typeof list[n] !== 'undefined') {
								if ((typeof list[n] === 'object') && (list[n] !== null)) {
									// Merge
									for (var z in val) {
										list[n].push(val[z]);
									}
								} else {
									list[n] = val;
								}
							} else {
								list[n] = val;
							}
						}
					}
				} else {
					list[n] = val;
				}
			} else {
				// Common control
				list[n] = val;
			}
		}
	});
	
	return list;
}

function jxAction(action, data, cb) {
	data['jx_action'] = action;
	jQuery.ajax({
		url: wpjxm_ajaxurl,
		method: 'POST',
		data: {'action': wpjxm_action, '__xr':1, 'z':JSON.stringify(data)},
		success: function(jx) {
			var ret = true;
			if ((typeof cb !== 'undefined') && (cb)) {
				var vars = {};
				for (var i = 0; i < jx.length; i ++) {
					switch (jx[i][0]) {
						case 'vr':
							vars[jx[i][1]] = jx[i][2];
							break;
					}
				}
				ret = cb(vars);
			}
			if ((ret) || (typeof ret === 'undefined')) {
				for (var i = 0; i < jx.length; i ++) {
					var jd = jx[i];
					switch (jd[0]) {
						case 'cn':
							console.log(jd[1]);
							break;
						case 'cl':
							window[jd[1]].apply(this, jd[2]);
							break;
						case 'al':
							alert(jd[1]);
							break;
						case 'as':
							if (jQuery(jd[1]).length > 0) {
								jQuery(jd[1]).html(jd[2]);
							}
							break;
						case 'js':
							eval(jd[1]);
							break;
						case 'rd':
							document.location.href = jd[1];
							break;
						case 'rl':
							window.location.reload();
						break;
					}
				}
			}
		},
		error: function() {
			console.log('Wrong jx JSON response (not JSON)');
		},
		dataType: 'json'
	});

}
