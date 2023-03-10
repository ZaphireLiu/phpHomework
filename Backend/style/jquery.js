/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.4.0
 *
 */
(function(n) {
    jQuery.fn.extend({
        slimScroll: function(i) {
            var r = n.extend({
                width: "auto",
                height: "250px",
                size: "7px",
                color: "#000",
                position: "right",
                distance: "1px",
                start: "top",
                opacity: .4,
                alwaysVisible: !1,
                disableFadeOut: !1,
                railVisible: !1,
                railColor: "#333",
                railOpacity: .2,
                railDraggable: !0,
                railClass: "slimScrollRail",
                barClass: "slimScrollBar",
                wrapperClass: "slimScrollDiv",
                allowPageScroll: !1,
                wheelStep: 20,
                touchScrollStep: 200,
                borderRadius: "7px",
                railBorderRadius: "7px"
            }, i);
            return this.each(function() {
                function y(t) {
                    var t, i, f;
                    l && (t = t || window.event,
                    i = 0,
                    t.wheelDelta && (i = -t.wheelDelta / 120),
                    t.detail && (i = t.detail / 3),
                    f = t.target || t.srcTarget || t.srcElement,
                    n(f).closest("." + r.wrapperClass).is(u.parent()) && h(i, !0),
                    t.preventDefault && !o && t.preventDefault(),
                    o || (t.returnValue = !1))
                }
                function h(n, t, i) {
                    var s, l, h;
                    o = !1;
                    s = n;
                    l = u.outerHeight() - f.outerHeight();
                    t && (s = parseInt(f.css("top")) + n * parseInt(r.wheelStep) / 100 * f.outerHeight(),
                    s = Math.min(Math.max(s, 0), l),
                    s = n > 0 ? Math.ceil(s) : Math.floor(s),
                    f.css({
                        top: s + "px"
                    }));
                    e = parseInt(f.css("top")) / (u.outerHeight() - f.outerHeight());
                    s = e * (u[0].scrollHeight - u.outerHeight());
                    i && (s = n,
                    h = s / u[0].scrollHeight * u.outerHeight(),
                    h = Math.min(Math.max(h, 0), l),
                    f.css({
                        top: h + "px"
                    }));
                    u.scrollTop(s);
                    u.trigger("slimscrolling", ~~s);
                    nt();
                    c()
                }
                function et() {
                    window.addEventListener ? (this.addEventListener("DOMMouseScroll", y, !1),
                    this.addEventListener("mousewheel", y, !1),
                    this.addEventListener("MozMousePixelScroll", y, !1)) : document.attachEvent("onmousewheel", y)
                }
                function g() {
                    a = Math.max(u.outerHeight() / u[0].scrollHeight * u.outerHeight(), ft);
                    f.css({
                        height: a + "px"
                    });
                    var n = a == u.outerHeight() ? "none" : "block";
                    f.css({
                        display: n
                    })
                }
                function nt() {
                    if (g(),
                    clearTimeout(tt),
                    e == ~~e) {
                        if (o = r.allowPageScroll,
                        it != e) {
                            var n = ~~e == 0 ? "top" : "bottom";
                            u.trigger("slimscroll", n)
                        }
                    } else
                        o = !1;
                    if (it = e,
                    a >= u.outerHeight()) {
                        o = !0;
                        return
                    }
                    f.stop(!0, !0).fadeIn("fast");
                    r.railVisible && s.stop(!0, !0).fadeIn("fast")
                }
                function c() {
                    r.alwaysVisible || (tt = setTimeout(function() {
                        r.disableFadeOut && l || p || w || (f.fadeOut("slow"),
                        s.fadeOut("slow"))
                    }, 1e3))
                }
                var l, p, w, tt, b, a, e, it, k = "<div><\/div>", ft = 30, o = !1, u = n(this), v, d, rt;
                if (u.parent().hasClass(r.wrapperClass)) {
                    if (v = u.scrollTop(),
                    f = u.parent().find("." + r.barClass),
                    s = u.parent().find("." + r.railClass),
                    g(),
                    n.isPlainObject(i)) {
                        if ("height"in i && i.height == "auto" && (u.parent().css("height", "auto"),
                        u.css("height", "auto"),
                        d = u.parent().parent().height(),
                        u.parent().css("height", d),
                        u.css("height", d)),
                        "scrollTo"in i)
                            v = parseInt(r.scrollTo);
                        else if ("scrollBy"in i)
                            v += parseInt(r.scrollBy);
                        else if ("destroy"in i) {
                            f.remove();
                            s.remove();
                            u.unwrap();
                            return
                        }
                        h(v, !1, !0)
                    }
                    return
                }
                r.height = r.height == "auto" ? u.parent().height() : r.height;
                rt = n(k).addClass(r.wrapperClass).css({
                    position: "relative",
                    overflow: "hidden",
                    width: r.width,
                    height: r.height
                });
                u.css({
                    overflow: "hidden",
                    width: r.width,
                    height: r.height
                });
                var s = n(k).addClass(r.railClass).css({
                    width: r.size,
                    height: "100%",
                    position: "absolute",
                    top: 0,
                    display: r.alwaysVisible && r.railVisible ? "block" : "none",
                    "border-radius": r.railBorderRadius,
                    background: r.railColor,
                    opacity: r.railOpacity,
                    zIndex: 90
                })
                  , f = n(k).addClass(r.barClass).css({
                    background: r.color,
                    width: r.size,
                    position: "absolute",
                    top: 0,
                    opacity: r.opacity,
                    display: r.alwaysVisible ? "block" : "none",
                    "border-radius": r.borderRadius,
                    BorderRadius: r.borderRadius,
                    MozBorderRadius: r.borderRadius,
                    WebkitBorderRadius: r.borderRadius,
                    zIndex: 99
                })
                  , ut = r.position == "right" ? {
                    right: r.distance
                } : {
                    left: r.distance
                };
                s.css(ut);
                f.css(ut);
                u.wrap(rt);
                u.parent().append(f);
                u.parent().append(s);
                r.railDraggable && f.bind("mousedown", function(i) {
                    var r = n(document);
                    return w = !0,
                    t = parseFloat(f.css("top")),
                    pageY = i.pageY,
                    r.bind("mousemove.slimscroll", function(n) {
                        currTop = t + n.pageY - pageY;
                        f.css("top", currTop);
                        h(0, f.position().top, !1)
                    }),
                    r.bind("mouseup.slimscroll", function() {
                        w = !1;
                        c();
                        r.unbind(".slimscroll")
                    }),
                    !1
                }).bind("selectstart.slimscroll", function(n) {
                    return n.stopPropagation(),
                    n.preventDefault(),
                    !1
                });
                s.hover(function() {
                    nt()
                }, function() {
                    c()
                });
                f.hover(function() {
                    p = !0
                }, function() {
                    p = !1
                });
                u.hover(function() {
                    l = !0;
                    nt();
                    c()
                }, function() {
                    l = !1;
                    c()
                });
                u.bind("touchstart", function(n) {
                    n.originalEvent.touches.length && (b = n.originalEvent.touches[0].pageY)
                });
                u.bind("touchmove", function(n) {
                    if (o || n.originalEvent.preventDefault(),
                    n.originalEvent.touches.length) {
                        var t = (b - n.originalEvent.touches[0].pageY) / r.touchScrollStep;
                        h(t, !0);
                        b = n.originalEvent.touches[0].pageY
                    }
                });
                g();
                r.start === "bottom" ? (f.css({
                    top: u.outerHeight() - f.outerHeight()
                }),
                h(0, !0)) : r.start !== "top" && (h(n(r.start).position().top, null, !0),
                r.alwaysVisible || f.hide());
                et()
            }),
            this
        }
    });
    jQuery.fn.extend({
        slimscroll: jQuery.fn.slimScroll
    })
}
)(jQuery);
//# sourceMappingURL=jquery.slimscroll.min.js.map
