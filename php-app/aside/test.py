import math

a = int(input())
b = int(input())
c = int(input())

D = math.pow(b, 2) - 4 * a * c
if D > 0:
    print('two roots:')
    x1 = (-b + math.sqrt(D)) / (2 * a)
    x2 = (-b - math.sqrt(D)) / (2 * a)
    print('x1 = %f' % x1)
    print('x2 = %f' % x2)
elif D == 0:
    print('one root:')
    x = (-b) / (2 * a)
    print('x = %f' % x)
else:
    print('no roots')